<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\PurchaseOrder;
use App\Supplier;
use App\User;
use App\Product;
use App\PurchaseOrderInvoice;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';

    protected $fillable = ['code', 'supplier_id', 'creator', 'status', 'notes'];

    public function supplier()
    {
    	return $this->belongsTo('App\Supplier');
    }

    public function created_by()
    {
    	return $this->belongsTo('App\User', 'creator');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity','price', 'purchase_order_id');
    }

    //relation to purchase order invoice
    public function purchase_order_invoice()
    {
        return $this->hasOne('App\PurchaseOrderInvoice');
    }
}
