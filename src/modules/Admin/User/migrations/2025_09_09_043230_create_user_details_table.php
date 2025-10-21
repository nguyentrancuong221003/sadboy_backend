<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('status', 15)->nullable();
            $table->date('date_birth')->nullable();
            $table->dateTime('date_create_account')->nullable();
            $table->decimal('money_spend', 15, 2)->nullable()->default(0);
            $table->string('type', 15)->default('NEW');
            $table->integer('number_carts')->default(0);
            $table->integer('total_order')->default(0);
            $table->integer('total_order_cancel')->default(0);
            $table->integer('total_order_success')->default(0);
            $table->integer('comment_count')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
