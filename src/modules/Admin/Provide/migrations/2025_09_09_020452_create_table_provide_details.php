<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProvideDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provide_details', function (Blueprint $table) {
            $table->unsignedBigInteger('provide_id')->primary();
            $table->integer('total_order')->default(0);
            $table->integer('return_order')->default(0);
            $table->decimal('total_buy', 15, 2)->default(0);
            $table->decimal('total_debt', 15, 2)->default(0);
            $table->string('bank', 30)->nullable();
            $table->string('account_name', 100)->nullable();
            $table->string('account_phone', 30)->nullable();
            $table->string('qr_img', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('provide_id')->references('id')->on('provides')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('provide_details');

    }
}
