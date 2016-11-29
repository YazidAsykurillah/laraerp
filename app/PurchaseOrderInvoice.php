<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\PurchaseOrder;
use App\User;

class PurchaseOrderInvoice extends Model
{
    protected $table = 'purchase_order_invoices';

    protected $fillable = ['code','purchase_order_id', 'bill_price', 'paid_price', 'paid_at', 'created_by', 'status', 'notes'];

    public function creator()
    {
    	return $this->belongsTo('App\User', 'created_by');
    }

    public function purchase_order()
    {
    	return $this->belongsTo('App\PurchaseOrder');
    }
}
