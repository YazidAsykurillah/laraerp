<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\SalesOrder;
use App\User;

class SalesOrderInvoice extends Model
{
    protected $table = 'sales_order_invoices';

    protected $fillable = ['code','sales_order_id', 'bill_price', 'paid_price', 'paid_at', 'created_by', 'status', 'notes', 'due_date'];

    public function creator()
    {
    	return $this->belongsTo('App\User', 'created_by');
    }

    public function sales_order()
    {
    	return $this->belongsTo('App\SalesOrder');
    }
}
