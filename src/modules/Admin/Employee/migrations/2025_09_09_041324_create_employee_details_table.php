<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_details', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->primary();
            $table->date('date_birth');
            $table->date('date_start_work');
            $table->integer('salary');
            $table->string('diploma', 20)->nullable();
            $table->string('status', 20)->nullable();
            $table->date('date_sign_contrast')->nullable();
            $table->date('date_effect_contrast')->nullable();
            $table->date('date_end_contrast')->nullable();
            $table->unsignedBigInteger('work_shift_id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('grant_id');
            $table->unsignedBigInteger('contrast_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->foreign('work_shift_id')->references('id')->on('work_shifts')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('grant_id')->references('id')->on('grants')->onDelete('cascade');
            $table->foreign('contrast_id')->references('id')->on('contrasts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_details');
    }
}
