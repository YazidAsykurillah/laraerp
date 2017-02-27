<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\SalesOrder;
use App\Customer;
use App\User;
use App\Product;
use App\SalesOrderInvoice;
use App\SalesReturn;
use App\SalesInvoicePayment;
use App\BankSalesInvoicePayment;
use App\CashSalesInvoicePayment;

class SalesOrder extends Model
{
    protected $table = 'sales_orders';

    protected $fillable = ['code', 'creator', 'customer_id', 'notes', 'status'];

    public function customer()
    {
    	return $this->belongsTo('App\Customer');
    }

    public function created_by()
    {
    	return $this->belongsTo('App\User', 'creator');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity','price', 'sales_order_id','price_per_unit');
    }

    //relation to sales order invoice
    public function sales_order_invoice()
    {
        return $this->hasOne('App\SalesOrderInvoice');
    }

    public function sales_invoice_payment()
    {
        return $this->hasMany('App\SalesInvoicePayment');
    }

    //relation to sales return
    public function sales_returns()
    {
        return $this->hasMany('App\SalesReturn');
    }

    public function bank_sales_invoice_payment()
    {
        return $this->hasMany('App\BankSalesInvoicePayment','sales_invoice_payment_id');
    }

    public function cash_sales_invoice_payment()
    {
        return $this->hasMany('App\CashSalesInvoicePayment','sales_invoice_payment_id');
    }
}
