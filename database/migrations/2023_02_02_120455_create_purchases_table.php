<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->string('code')->nullable();
            $table->string('payment_gateway');
            $table->string('status');
            $table->string('currency');
            $table->string('totalamount');
            $table->string('merchant_commission');
            $table->decimal('price', 11, 4);
            $table->text('description');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->dateTime('transaction_date');
            $table->decimal('payment_gateway_commission', 11, 4);
            $table->decimal('selar_profit', 11, 4);

            $table->index(['merchant_id', 'selar_profit'], 'merchant_profit_index');
            $table->index(['created_at', 'updated_at'], 'timestamp_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
