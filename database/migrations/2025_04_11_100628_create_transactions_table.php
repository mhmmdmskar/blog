<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->integer('price');
            $table->integer('quantity');
            $table->integer('total_price'); // <<== TAMBAH DI SINI
            $table->timestamps();
        });
    }    

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}
