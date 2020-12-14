<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EcomPlatform;
use App\Models\ShopifyProduct;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use GuzzleHttp\Client;

class ProductsShopify extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();
        return view('main.products.shopify',
            ['user'=>$user]
        );
    }

    public function getAll()
    {   
        ini_set('max_execution_time', 300);
        $platform = EcomPlatform::find(3); //id 3 = shopify
        $api_key = '';
        $password = '';
        $shop_name = '';
        if ($platform->api_key != '') {
            $api_key = Crypt::decryptString($platform->api_key);
        }
        else {
            echo 'Missing API Key.';
        }
        if ($platform->password != '') {
            $password = Crypt::decryptString($platform->password);
        } else {
            echo 'Missing Password.';
        }
        if ($platform->base_shop_name != '') {
            $shop_name = $platform->base_shop_name;
        }
        else {
            echo 'Missing Shop name.';
        }

        $products = array();
        $nextPageToken = null;
        do{
            $response = $this->request('get','products.json?limit=250&page_info='.$nextPageToken,$api_key,$password,$shop_name);
            foreach($response['resource'] as $product){
                array_push($products, $product);
            }
            $nextPageToken = $response['next']['page_token'] ?? null;
        } while($nextPageToken != null);

        $i = 1;
        foreach ($products as $product) {
            // title, quantity, handle, product_id, variant_id, category, brand
            $title = '';
            $quantity = 0;
            $url = ''; //handle
            $product_id = '';
            $variant_id = '';
            $category = ''; //product_type
            $brand = ''; //vendor

            $variants = $product['variants'];
            if (!empty($variants)) {
                foreach ($variants as $variant) {
                    $vt = '';
                    if ($variant['title'] == 'Default Title') {
                        $vt = '';
                    } else {
                        $vt = ' - '.$variant['title'];
                    }
                    $data = array();
                    $data['name'] = $product['title'].$vt;
                    echo $i.']  '.$data['name'];
                    echo '<br>';
                    $data['quantity'] = $variant['inventory_quantity'];
                    $data['url'] = $product['handle'];
                    $data['product_id'] = $variant['product_id'];
                    $data['variant_id'] = $variant['id'];
                    $data['category'] = $product['product_type'];
                    $data['brand'] = $product['vendor'];

                    $shopify_product = ShopifyProduct::updateOrCreate(
                        ['name' => $data['name'], 'variant_id' => $data['variant_id']],
                        $data
                    );
                    echo '<br>';
                    echo '<hr>';
                    $i++;
                }
            }
        }
        exit();
    }

    public function request($method,$endpoint,$api_key,$password,$shop_name,$param = [])
    {
        $client = new \GuzzleHttp\Client();
        $base_url = "https://$api_key:$password@$shop_name.myshopify.com/admin/api/2020-10/";
        $parameters = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ];
        if(!empty($param)){ $parameters['json'] = $param;}
        $response = $client->request($method, $base_url.$endpoint,$parameters);
        $responseHeaders = $response->getHeaders();
        $tokenType = 'next';
        if(array_key_exists('Link',$responseHeaders)){
            $link = $responseHeaders['Link'][0];
            $tokenType  = strpos($link,'rel="next') !== false ? "next" : "previous";
            $tobeReplace = ["<",">",'rel="next"',";",'rel="previous"'];
            $tobeReplaceWith = ["","","",""];
            parse_str(parse_url(str_replace($tobeReplace,$tobeReplaceWith,$link),PHP_URL_QUERY),$op);
            $pageToken = trim($op['page_info']);
        }
        $rateLimit = explode('/', $responseHeaders["X-Shopify-Shop-Api-Call-Limit"][0]);
        $usedLimitPercentage = (100*$rateLimit[0])/$rateLimit[1];
        if($usedLimitPercentage > 95){sleep(5);}
        $responseBody = json_decode($response->getBody(),true);
        $r['resource'] =  (is_array($responseBody) && count($responseBody) > 0) ? array_shift($responseBody) : $responseBody;
        $r[$tokenType]['page_token'] = isset($pageToken) ? $pageToken : null;
        return $r;
    }

    public function all(Request $request)
    {
        $platform = EcomPlatform::find(3); //id 3 = shopify

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $products = ShopifyProduct::all();

        $data = array();

        foreach ($products as $product) {
            $data[] = array(
                //$product->id,
                $product->name,
                $product->quantity,
                $product->category,
                $product->brand,
                '<a href="'.$platform->shop_url.'products/'.$product->url.'?variant='.$product->variant_id.'" target="_blank"><i class="fas fa-external-link-alt"></i></a>',
                '<a href="javascript:void(0)" class="edit-link" data-toggle="modal" data-target="#edit-quantity" data-id="'.$product->id.'"  data-qty="'.$product->quantity.'" data-title="'.$product->name.'">Edit</a>'
            );
        }

        $response = array(
            "draw" => intval($draw),
            "total" => count($products),
            "data" => $data
        );

        echo json_encode($response);
        exit;
    }

    public function updateQuantity($id,Request $request)
    {
        $new_qty = $request->input('quantity');

        $product = ShopifyProduct::find($id);
        $product->quantity = $new_qty;
        $saved = $product->save();

        $product_id = $product->product_id;
        $variant_id = $product->variant_id;

        $platform = EcomPlatform::find(3); //id 3 = shopify
        $api_key = '';
        $password = '';
        $shop_name = '';
        if ($platform->api_key != '') {
            $api_key = Crypt::decryptString($platform->api_key);
        }
        else {
            echo 'Missing API Key.';
        }
        if ($platform->password != '') {
            $password = Crypt::decryptString($platform->password);
        } else {
            echo 'Missing Password.';
        }
        if ($platform->base_shop_name != '') {
            $shop_name = $platform->base_shop_name;
        }
        else {
            echo 'Missing Shop name.';
        }

        //get inventory item id
        $response = $this->request2('GET','products/'.$product_id.'/variants/'.$variant_id.'.json', $api_key, $password, $shop_name);
        $variant = $response['variant'];
        $inventory_item_id = '';
        if (array_key_exists('inventory_item_id', $variant)) {
            $inventory_item_id = $variant['inventory_item_id'];
        }

        //get location id
        $location_id = '';
        if ($inventory_item_id != '') {
            $response = $this->request2('GET','inventory_levels.json?inventory_item_ids='.$inventory_item_id, $api_key, $password, $shop_name);
            $inventory_levels = $response['inventory_levels'];
            $location_id = $inventory_levels[0]['location_id'];
        }

        //set new available inventory
        if ($inventory_item_id != '' && $location_id != '') {
            $data = array(
                "location_id" => $location_id,
                "inventory_item_id" => $inventory_item_id,
                "available" => $new_qty
            );
            $response = $this->request2('POST','inventory_levels/set.json', $api_key, $password, $shop_name, $data);
        }

        $response = array();
        if (!$saved) {
            $response = array('status' => 'error', 'message' => 'Something went wrong. Please contact the administrator.', 'product' => $product->name);
        } else {
            $response = array('status'=> 'success', 'message' => 'Inventory quantity has been updated.', 'product' => $product->name);
        }

        echo json_encode($response);
        exit;
    }

    public function request2($method,$endpoint,$api_key,$password,$shop_name,$param=[])
    {
        $client = new \GuzzleHttp\Client();
        $base_url = "https://$api_key:$password@$shop_name.myshopify.com/admin/api/2020-10/";
        $parameters = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ];
        if(!empty($param)){ $parameters['json'] = $param;}
        $response = $client->request($method, $base_url.$endpoint,$parameters);
        $body = $response->getBody();
        $stringBody = (string) $body;
        $json = json_decode($body,true);
        return $json;
    }
}