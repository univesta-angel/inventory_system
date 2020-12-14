<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\ShopifyProduct;

class Audit extends Model
{
    protected $table = 'audits';

    public function user()
    {
    	return $this->hasOne('App\Models\User', 'id', 'user_id')->first()->name;
    }

    public function product()
    {
    	if ($this->auditable_type == 'App\Models\ShopifyProduct') {
    		return $this->hasOne('App\Models\ShopifyProduct', 'id', 'auditable_id')->first()->name;
    	}	
    }

    public function old_value()
    {
    	$json = json_decode($this->old_values);
    	return $json->quantity;
    }

    public function new_value()
    {
    	$json = json_decode($this->new_values);
    	return $json->quantity;
    }

    public function platform()
    {
    	if ($this->auditable_type == 'App\Models\ShopifyProduct') {
    		return 'Shopify';
    	}
    }
}