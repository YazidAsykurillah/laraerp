<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\PurchaseOrder;
use App\Supplier;
use App\User;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';

    protected $fillable = ['code', 'supplier_id', 'creator', 'status'];

    public function supplier()
    {
    	return $this->belongsTo('App\Supplier');
    }

    public function created_by()
    {
    	return $this->belongsTo('App\User', 'creator');
    }

}
