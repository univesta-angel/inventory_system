<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Audit;
use App\Models\EcomPlatform;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use GuzzleHttp\Client;

use Paulwscom\Lazada\LazopClient;
use Paulwscom\Lazada\LazopRequest;

class LazadaCallback extends Controller
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
    }

    public function callback(Request $request){
        $arr = $request->all();
        $code = $arr['code'];

        DB::table('lazada_auth')->insert([
            'code' => Crypt::encryptString($code)
        ]);

        $platform = EcomPlatform::find(2);
        if ($platform->api_key != '') {
            $appkey = Crypt::decryptString($platform->api_key);
        }
        else {
            echo 'Missing API Key.<br>';
        }
        if ($platform->password != '') {
            $appSecret = Crypt::decryptString($platform->password);
        } else {
            echo 'Missing Password.<br>';
        }

        $c = new LazopClient($url,$appkey,$appSecret);
        $request = new LazopRequest('/auth/token/create');
        $request->addApiParam('code','0_124157_dxtu3JzMDqZMFTpbEeKD7p0T34358');

        $result = $c->execute($request);
        $json = json_decode($result,true);

        var_dump($json);

        /*DB::table('lazada_auth')->insert([
            'access_token' => $json['access_token'],
            'refresh_token' => $json['refresh_token'],
            'country' => $json['country'],
            'refresh_expires_in' => $json['refresh_expires_in'],
            'account_platform' => $json['account_platform'],
            'expires_in' => $json['expires_in'],
            'account' => $json['account'],
            'country_user_info' => json_encode($json['country'])
        ]);

        echo 'Authorization success and access token saved!';*/
        die();
    }

    /*public function request2($method,$endpoint,$app_key,$app_secret,$param=[])
    {
        $client = new \GuzzleHttp\Client();
        $base_url = "https://api.lazada.com.ph/rest";
        $parameters = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
                'app_key' => $app_key
            ]
        ];
        if(!empty($param)){ $parameters['json'] = $param;}
        $base_url = "https://api.lazada.com.ph/rest";
        $response = $client->request($method, $base_url.$endpoint,$parameters);
        $body = $response->getBody();
        $stringBody = (string) $body;
        $json = json_decode($body,true);
        return $json;
    }*/
}