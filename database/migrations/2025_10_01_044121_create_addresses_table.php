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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('street_id');
            $table->string('house', 20);
            $table->string('flat', 20)->nullable();
            $table->unsignedTinyInteger('floor')->nullable();
            $table->unsignedTinyInteger('entrance')->nullable();
            $table->boolean('entrance_is_locked')->nullable();
            $table->boolean('has_gate')->nullable();
            $table->string('comment', 100)->nullable();
            $table->timestamps();
            $table->foreign('street_id')->references('id')->on('streets')->onDelete('restrict');
            $table->index('street_id');
            $table->index('house');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
