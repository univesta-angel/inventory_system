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
    }

    public function callback(Request $request){
        // echo 'abc';
        // get code from auth
        

    }
}