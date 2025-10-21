<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSuccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_success', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->primary();
            $table->decimal('total_import_price', 15, 2);
            $table->decimal('discount_price', 15, 2);
            $table->decimal('total_sale_price', 15, 2);
            $table->decimal('total_profitable_price', 15, 2);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_success');
    }
}
