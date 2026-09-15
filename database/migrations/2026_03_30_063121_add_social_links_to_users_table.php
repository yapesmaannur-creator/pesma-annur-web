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
        Schema::table('users', function (Blueprint $table) {
            $table->string('social_fb')->nullable()->after('bio');
            $table->string('social_ig')->nullable()->after('social_fb');
            $table->string('social_x')->nullable()->after('social_ig');
            $table->string('social_linkedin')->nullable()->after('social_x');
            $table->string('social_scholar')->nullable()->after('social_linkedin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'social_fb',
                'social_ig',
                'social_x',
                'social_linkedin',
                'social_scholar'
            ]);
        });
    }
};
