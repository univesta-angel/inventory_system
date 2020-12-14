<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ShopifyProduct extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'products_shopify';

    protected $fillable = ['name','quantity','url','product_id','variant_id','category','brand'];
}