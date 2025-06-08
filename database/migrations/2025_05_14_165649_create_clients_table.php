<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('client_id');
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('wilaya')->nullable();
            $table->text('address')->nullable();
            $table->string('number',10)->unique;
            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
