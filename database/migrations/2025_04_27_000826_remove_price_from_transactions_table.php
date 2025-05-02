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
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropColumn('price');  // Menghapus kolom 'price' dari tabel transactions
    });
}

public function down()
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->decimal('price', 12, 2)->nullable();  // Menambahkan kolom 'price' kembali jika rollback
    });
}
};
