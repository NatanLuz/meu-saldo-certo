<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
    * Executa as migracoes.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['income', 'expense']);
            $table->timestamps();

            $table->unique(['name', 'type']);
        });
    }

    /**
        * Reverte as migracoes.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
