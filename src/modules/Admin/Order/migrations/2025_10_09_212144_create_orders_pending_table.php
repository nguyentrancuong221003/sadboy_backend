<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersPendingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_pending', function (Blueprint $table) {
            $table->id();
            $table->string('code', 15)->unique();
            $table->string('name')->nullable()->nullable();
            $table->dateTime('date_delivery');
            $table->json('products');
            $table->string('status', 15)->default('PENDING');
            $table->integer('count');
            $table->decimal('total', 15, 2);
            $table->unsignedBigInteger('user_id')->nullable();
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

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_pending');
    }
}
