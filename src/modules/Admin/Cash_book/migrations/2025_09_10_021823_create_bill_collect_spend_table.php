<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillCollectSpendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_collect_spend', function (Blueprint $table) {
            $table->id();
            $table->string('code', 15)->unique();
            $table->string('type', 15);
            $table->string('reason', 400);
            $table->decimal('money', 15, 2);
            $table->json('imgs');
            $table->string('object', 400);
            $table->string('name_object', 400);

            $table->softDeletes();
            $table->string('created_by', 400);
            $table->string('updated_by', 400);
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
        Schema::dropIfExists('bill_collect_spend');
    }
}
