<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Audit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class AuditTrail extends Controller
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
        $audits = Audit::where('auditable_type', 'App\Models\ShopifyProduct')->where('event', 'updated')->orderBy('created_at', 'DESC')->simplePaginate(10);
        return view('main.audit_trail',
            ['user'=>$user,
            'audits'=>$audits]
        );
    }
}