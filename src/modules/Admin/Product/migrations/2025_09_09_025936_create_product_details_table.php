<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->primary();
            $table->json('import_price');
            $table->json('original_price');
            $table->json('sale_price')->nullable();
            $table->text('sort_description')->nullable();
            $table->string('long_description', 100)->nullable();
            $table->integer('count_comment')->default(0);
            $table->string('QR', 30)->nullable();
            $table->integer('proportion_discount')->default(0);
            $table->dateTime('date_start_sale')->nullable();
            $table->dateTime('date_end_sale')->nullable();
            $table->integer('count_stock');
            $table->integer('count_sale')->default(0);
            $table->string('status', 15)->default('ACTIVE');
            $table->string('unit', 7)->nullable();

            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Table productDetails {
  product_id int
  import_price json [not null]
  original_price json [not null]
  sale_price json
  sort_description varchar(300)
  long_description varchar(100)
  count_comment int
  OR varchar(30)
  proportion_discount int
  date_start_sale datetime
  date_end_sale datetime
  count_stock int [not null]
  count_sale int
  status varchar(15)
  unit varchar(7)

  created_at timestamp
  updated_at timestamp
  created_by varchar(100)
  updated_by varchar(100)
  deleted_at timestamp
}
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_details');
    }
}
