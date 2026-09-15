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
        Schema::table('page_sections', function (Blueprint $table) {
            $table->string('image2')->nullable()->after('image');
            $table->string('image3')->nullable()->after('image2');
            $table->string('button_text')->nullable()->after('image3');
            $table->string('button_url')->nullable()->after('button_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropColumn(['image2', 'image3', 'button_text', 'button_url']);
        });
    }
};
