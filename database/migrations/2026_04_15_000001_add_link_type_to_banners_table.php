<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tambah kolom link_type: 'button' = tampilkan tombol, 'image' = klik seluruh gambar
     */
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('link_type')->default('button')->after('link');
            // button = link muncul sebagai tombol di tengah banner
            // image  = seluruh gambar bisa diklik, teks/tombol disembunyikan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('link_type');
        });
    }
};
