<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    // Hapus foreign key constraint terlebih dahulu
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropForeign(['product_id']);  // Hapus foreign key
    });

    // Setelah itu, baru bisa menghapus kolom 'product_id'
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropColumn('product_id');  // Hapus kolom product_id
    });
}

public function down()
{
    // Jika rollback, kembalikan kolom product_id dan foreign key
    Schema::table('transactions', function (Blueprint $table) {
        $table->bigInteger('product_id')->unsigned()->nullable();
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}

};
