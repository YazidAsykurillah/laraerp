<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\SalesOrder;
use App\User;
use App\PaymentMethod;
use App\SalesInvoicePayment;

class SalesOrderInvoice extends Model
{
    protected $table = 'sales_order_invoices';

    protected $fillable = ['code','sales_order_id', 'bill_price', 'paid_price', 'paid_at', 'created_by', 'status', 'notes' ,'payment_method_id'];

    public function creator()
    {
    	return $this->belongsTo('App\User', 'created_by');
    }

    public function sales_order()
    {
    	return $this->belongsTo('App\SalesOrder');
    }

    public function payment_method()
    {
        return $this->belongsTo('App\PaymentMethod');
    }
    public function sales_invoice_payment()
    {
        return $this->hasMany('App\SalesInvoicePayment', 'sales_order_invoice_id');
    }

}
