<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = ['code', 'name', 'pic_name', 'primary_email', 'primary_phone_number', 'address'];

    
}
