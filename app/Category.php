<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Product;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['code','name'];

    //relation to Product
    public function products()
    {
    	return $this->hasMany('App\Product');
    }

}
