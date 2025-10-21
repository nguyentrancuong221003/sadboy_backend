<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtProvidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debt_provides', function (Blueprint $table) {
            $table->id();
            $table->string('code', 15)->unique();
            $table->date('date');
            $table->decimal('initial_debt', 15, 2);
            $table->decimal('debt_arises', 15, 2);
            $table->decimal('debt_paid', 15, 2);
            $table->decimal('debt_final', 15, 2);

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
        Schema::dropIfExists('debt_provides');
    }
}
