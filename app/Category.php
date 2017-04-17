<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\MainProduct;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['code','name'];

    //relation to Product
    public function main_products()
    {
    	return $this->hasMany('App\MainProduct');
    }

}
