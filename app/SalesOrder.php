<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Customer;
use App\User;
use App\Product;
use App\SalesOrderInvoice;

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
        return $this->belongsToMany('App\Product')->withPivot('quantity','price', 'sales_order_id');
    }

    //relation to sales order invoice
    public function sales_order_invoice()
    {
        return $this->hasOne('App\SalesOrderInvoice');
    }

    //relation to sales return
    public function sales_returns()
    {
        return $this->hasMany('App\SalesReturn');
    }
}
