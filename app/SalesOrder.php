<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Customer;
use App\User;
use App\Product;

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
}
