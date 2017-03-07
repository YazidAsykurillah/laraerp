<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Cash;
use App\Bank;

class SubChartAccount extends Model
{
    protected $table = 'sub_chart_accounts';

    protected $fillable = ['reference','account_number','chart_account_id'];

    public function cashs()
    {
        return $this->belongsTo('App\Cash','reference');
    }

    public function banks()
    {
        return $this->belongsTo('App\Bank','reference');
    }

}
