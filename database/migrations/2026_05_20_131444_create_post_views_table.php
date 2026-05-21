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
        Schema::create('post_views', function (Blueprint $table) {
            $table->id();
            // Ո՞վ է նայել (nullable է, եթե հյուրերն էլ են նայում)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            // Ո՞ր պոստն է նայել
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            // Օգտատիրոջ IP հասցեն (որպեսզի նույն մարդուն անընդհատ չհաշվի)
            $table->string('ip_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_views');
    }
};
