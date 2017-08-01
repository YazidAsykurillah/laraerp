<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';

    protected $fillable = ['account_name', 'account_number', 'sub_chart_account_id'];

}
