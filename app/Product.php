<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Category;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['code', 'name', 'category_id', 'image'];

    //relation to Category
    public function category(){
    	return $this->belongsTo('App\Category');
    }


}
