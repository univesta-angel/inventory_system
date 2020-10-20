<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EcomPlatform;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class SettingsController extends Controller
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
        $platforms = EcomPlatform::all();
        return view('main.settings.list',
            ['user'=>$user,
            'platforms'=>$platforms]
        );
    }
    public function edit($id)
    {
        $user = Auth::user();
        $platform = EcomPlatform::find($id);
        return view('main.settings.edit',
            ['user'=>$user,
            'platform'=>$platform]
        );
    }
    public function update($id, Request $request)
    {
        $data = $request->except(['_token','_method']);
        if (array_key_exists("api_key",$data)) {
            $var = $data['api_key'];
            $data['api_key'] = Crypt::encryptString($var);
        }
        if (array_key_exists("password",$data)) {
            $var = $data['password'];
            $data['password'] = Crypt::encryptString($var);
        }

        $platform = EcomPlatform::find($id);
        $platform->name = $data['name'];
        $platform->api_key = $data['api_key'];
        $platform->password = $data['password'];
        $platform->shop_url = $data['shop_url'];
        if (array_key_exists('base_shop_name', $data)) {
            $platform->base_shop_name = $data['base_shop_name'];
        }
        $saved = $platform->save();

        if(!$saved) {
            return back()->with('errors', 'Something went wrong. Please contact the adminstrator.');
        } else {
            return redirect()->route('setting',['id'=>$id])
            ->with('message',"Successfully updated.");
        }
        
    }

}