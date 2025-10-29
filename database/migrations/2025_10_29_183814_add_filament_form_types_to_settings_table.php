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
        Schema::table('settings', function (Blueprint $table) {
            $table->enum('type', [
                'string',
                'text',
                'boolean',
                'integer',
                'float',
                'array',
                'json',
                'file',
                'date',
                'datetime',
                'color_picker',
                'code_editor',
                'rich_editor',
                'markdown_editor',
                'tags_input',
                'checkbox_list',
                'radio',
                'toggle_buttons',
                'slider',
                'key_value',
            ])->default('string')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->enum('type', [
                'string',
                'text',
                'boolean',
                'integer',
                'float',
                'array',
                'json',
                'file',
                'date',
                'datetime',
            ])->default('string')->change();
        });
    }
};
