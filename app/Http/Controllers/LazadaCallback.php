<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Audit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


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
        echo 'Authorization success!';
        die();
    }

    public function callback(Request $request){
        var_dump($request->all());
        die();
    }
}