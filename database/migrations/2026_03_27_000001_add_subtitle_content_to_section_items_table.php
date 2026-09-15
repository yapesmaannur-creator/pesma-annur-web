<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('section_items', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('title');
            $table->longText('content')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('section_items', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'content']);
        });
    }
};
