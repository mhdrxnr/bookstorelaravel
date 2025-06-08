<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('orderDetail_id');
            $table->integer('quantity');
            $table->decimal('unitPrice',8,2);
            $table->unsignedBigInteger('bookID');
            $table->unsignedBigInteger('orderID');
            $table->foreign('orderID')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('bookID')->references('book_id')->on('books')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
