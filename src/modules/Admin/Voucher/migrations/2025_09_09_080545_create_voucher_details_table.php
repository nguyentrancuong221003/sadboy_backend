<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_details', function (Blueprint $table) {
            $table->unsignedBigInteger('voucher_id')->primary();
            $table->integer('total_user');
            $table->integer('count_use')->default(0);
            $table->integer('per_use');
            $table->decimal('order_price_smallest', 15, 2);
            $table->string('user_apply', 15);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->dateTime('date_effect');
            $table->dateTime('date_end');
            $table->string('status', 15);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_details');
    }
}
