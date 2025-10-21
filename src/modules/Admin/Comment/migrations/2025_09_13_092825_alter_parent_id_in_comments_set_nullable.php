<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterParentIdInCommentsSetNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('comments', function (Blueprint $table) {
        //     // 1. Xoá foreign key trước
        //     $table->dropForeign(['parent_id']);
        //     // 2. Xoá cột
        //     $table->dropColumn('parent_id');
        // });

        // Schema::table('comments', function (Blueprint $table) {
        //     // 3. Thêm lại cột với nullable
        //     $table->unsignedBigInteger('parent_id')->nullable()->after('star');
        //     $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        // });
    }

    public function down()
    {
        // Schema::table('comments', function (Blueprint $table) {
        //     // rollback: xoá foreign key trước
        //     $table->dropForeign(['parent_id']);
        //     $table->dropColumn('parent_id');
        // });

        // Schema::table('comments', function (Blueprint $table) {
        //     // thêm lại như cũ
        //     $table->integer('parent_id')->after('star');
        // });
    }

}
