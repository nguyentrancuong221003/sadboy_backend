<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeSpendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_spend', function (Blueprint $table) {
            $table->id();
            $table->string('code', 15)->unique();
            $table->date('date');
            $table->decimal('opening_balance', 15, 2);
            $table->decimal('money_in', 15, 2);
            $table->decimal('money_out', 15, 2);
            $table->decimal('profitable', 15, 2);
            $table->decimal('profit_order', 15, 2);
            $table->decimal('profit_vote', 15, 2);

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
        Schema::dropIfExists('income_spend');
    }
}
