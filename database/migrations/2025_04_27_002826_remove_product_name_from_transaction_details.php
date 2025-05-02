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
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn('product_name');  // Menghapus kolom 'product_name'
        });
    }
    
    public function down()
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->string('product_name');  // Menambahkan kolom kembali jika rollback
        });
    }    
};
