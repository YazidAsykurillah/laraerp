<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionChartAccount extends Model
{
    protected $table = 'transaction_chart_accounts';

    protected $fillable = ['amount','sub_chart_account_id'];
}
