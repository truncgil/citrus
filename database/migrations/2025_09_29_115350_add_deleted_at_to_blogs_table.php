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
        Schema::table('blogs', function (Blueprint $table) {
            // Eğer deleted_at sütunu yoksa ekle
            if (!Schema::hasColumn('blogs', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // deleted_at sütununu sil
            if (Schema::hasColumn('blogs', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
