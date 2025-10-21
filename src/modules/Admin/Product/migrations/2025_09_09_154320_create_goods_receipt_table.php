<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_receipt', function (Blueprint $table) {
            $table->id();
            $table->string('code', 15)->unique();
            $table->integer('count');
            $table->date('date_receive');
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('total', 15, 2);
            $table->string('note', 300)->nullable();
            $table->string('note_cancel', 300)->nullable();
            $table->decimal('other_cost', 15, 2)->default(0);
            $table->json('products');
            $table->string('status')->default('PENDING');
            $table->unsignedBigInteger('provide_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('stock_id')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('provide_id')->references('id')->on('provides')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_receipt');
    }
}
