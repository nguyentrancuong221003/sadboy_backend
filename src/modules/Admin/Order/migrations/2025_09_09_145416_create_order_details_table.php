<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->primary();
            $table->string('address');
            $table->string('pay', 15);
            $table->string('discount_code', 15)->nullable();
            $table->string('unit_shipping', 15)->nullable();
            $table->string('note', 500)->nullable();
            $table->string('note_cancel')->nullable();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('money_discount')->default(0);
            $table->decimal('money_ship')->default(0);
            $table->decimal('paid')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
