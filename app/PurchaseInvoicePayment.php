<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PaymentMethod;
use App\Bank;

class PurchaseInvoicePayment extends Model
{
    protected $table = 'purchase_invoice_payments';

    protected $fillable = ['purchase_order_invoice_id', 'amount', 'receiver'];

    public function bank(){
    	
    }


}
