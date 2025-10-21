<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provides', function (Blueprint $table) {
            $table->id(); // id int auto_increment, primary key, unsignedBigInteger
            $table->string('code', 15)->unique();
            $table->string('name', 70);
            $table->string('phone', 10)->unique();
            $table->string('address', 100);
            $table->string('email', 100)->unique();
            $table->string('img', 100)->nullable();
            $table->text('note')->nullable();
            $table->string('status', 15)->default('ACTIVE');
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->softDeletes();
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
        // Schema::table('provides', function (Blueprint $table) {
        //     $table->dropForeign(['provide_id']); // hoặc tên cột FK bạn đã khai báo
        //     $table->dropForeign(['product_id']);
        // });
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('provides');
        Schema::enableForeignKeyConstraints();
    }
}
