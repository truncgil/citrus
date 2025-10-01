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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('translatable_type')->comment('Model class name');
            $table->unsignedBigInteger('translatable_id')->comment('Model ID');
            $table->string('language_code', 10)->comment('Language code');
            $table->string('field_name', 100)->comment('Field name to translate');
            $table->longText('field_value')->nullable()->comment('Translated value');
            $table->enum('status', ['draft', 'review', 'approved', 'published'])->default('draft')->comment('Translation status');
            $table->integer('version')->default(1)->comment('Translation version');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['translatable_type', 'translatable_id']);
            $table->index(['language_code', 'status']);
            $table->index(['created_by', 'status']);
            $table->index('approved_by');
            
            // Unique constraint: one translation per model+field+language
            $table->unique(['translatable_type', 'translatable_id', 'language_code', 'field_name'], 'unique_translation');
            
            // Foreign key for language
            $table->foreign('language_code')->references('code')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
