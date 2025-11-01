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
        Schema::table('header_templates', function (Blueprint $table) {
            $table->json('default_data')->nullable()->after('html_content');
        });

        Schema::table('footer_templates', function (Blueprint $table) {
            $table->json('default_data')->nullable()->after('html_content');
        });

        Schema::table('section_templates', function (Blueprint $table) {
            $table->json('default_data')->nullable()->after('html_content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('header_templates', function (Blueprint $table) {
            $table->dropColumn('default_data');
        });

        Schema::table('footer_templates', function (Blueprint $table) {
            $table->dropColumn('default_data');
        });

        Schema::table('section_templates', function (Blueprint $table) {
            $table->dropColumn('default_data');
        });
    }
};
