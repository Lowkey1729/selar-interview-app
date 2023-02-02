<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('currency');
            $table->decimal('price', 11, 4);
            $table->unsignedBigInteger('merchant_id');
            $table->text('description');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->index(['merchant_id', 'currency'], 'merchant_currency_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
