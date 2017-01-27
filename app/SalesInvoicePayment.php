<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesInvoicePayment extends Model
{
    protected $table = 'sales_invoice_payments';
    protected $fillable = ['sales_order_invoice_id', 'amount', 'payment_method_id', 'receiver'];
}