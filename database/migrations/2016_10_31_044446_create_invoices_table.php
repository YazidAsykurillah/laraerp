<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table){
            $table->increments('id');
            $table->enum('type', ['sales', 'purchase'])->default('sales');
            $table->string('code')->unique();
            $table->integer('created_by');
            $table->date('due_date');
            $table->boolean('is_completed')->default(FALSE);
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
        Schema::drop('invoices');
    }
}
