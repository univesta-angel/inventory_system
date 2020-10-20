<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EComPlatform extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'ecom_platforms';
    
}