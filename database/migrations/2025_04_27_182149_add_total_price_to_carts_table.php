<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalPriceToCartsTable extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            // Menambahkan kolom total_price ke tabel carts
            $table->decimal('total_price', 10, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            // Menghapus kolom total_price jika migration dibatalkan
            $table->dropColumn('total_price');
        });
    }
}
