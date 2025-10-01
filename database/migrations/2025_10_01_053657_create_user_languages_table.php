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
        Schema::create('user_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('language_code', 10);
            $table->boolean('can_create')->default(true)->comment('Can create content in this language');
            $table->boolean('can_edit')->default(true)->comment('Can edit content in this language');
            $table->boolean('can_approve')->default(false)->comment('Can approve translations in this language');
            $table->boolean('can_publish')->default(false)->comment('Can publish content in this language');
            $table->timestamps();
            
            // Unique constraint: one entry per user+language
            $table->unique(['user_id', 'language_code']);
            
            // Foreign key for language
            $table->foreign('language_code')->references('code')->on('languages')->onDelete('cascade');
            
            // Indexes
            $table->index(['user_id', 'language_code']);
            $table->index('language_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_languages');
    }
};
