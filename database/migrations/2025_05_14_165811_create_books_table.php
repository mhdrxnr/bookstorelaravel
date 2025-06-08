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
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('title');
            $table->string('author');
            $table->decimal('price',8,2);
            $table->text('description')->nullable();
             $table->string('image')->nullable(); 
            $table->unsignedBigInteger('categoryID');
            $table->foreign('categoryID')->references('category_id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
