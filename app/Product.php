<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Category;
use App\Unit;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['code', 'name', 'category_id', 'image', 'unit_id'];

    //relation to Category
    public function category(){
    	return $this->belongsTo('App\Category');
    }

    //relation to Unit
    public function unit(){
    	return $this->belongsTo('App\Unit');
    }


}
