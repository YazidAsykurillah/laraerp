<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGiroSalesInvoicePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('giro_sales_invoice_payment', function(Blueprint $table){
        $table->string('no_giro');
        $table->string('bank');
        $table->date('tanggal_cair');
        $table->decimal('amount',20,2);
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('giro_sales_invoice_payment');
    }
}
