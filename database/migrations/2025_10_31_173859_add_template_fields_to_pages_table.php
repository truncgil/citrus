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
        Schema::table('pages', function (Blueprint $table) {
            $table->foreignId('header_template_id')->nullable()->after('id')->constrained('header_templates')->nullOnDelete();
            $table->json('header_data')->nullable()->after('header_template_id');
            
            $table->foreignId('footer_template_id')->nullable()->after('header_data')->constrained('footer_templates')->nullOnDelete();
            $table->json('footer_data')->nullable()->after('footer_template_id');
            
            $table->json('sections_data')->nullable()->after('footer_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['header_template_id']);
            $table->dropColumn('header_template_id');
            $table->dropColumn('header_data');
            
            $table->dropForeign(['footer_template_id']);
            $table->dropColumn('footer_template_id');
            $table->dropColumn('footer_data');
            
            $table->dropColumn('sections_data');
        });
    }
};
