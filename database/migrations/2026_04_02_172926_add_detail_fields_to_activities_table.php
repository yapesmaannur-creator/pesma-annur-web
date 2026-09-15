<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('location')->nullable()->after('date');
            $table->time('time_start')->nullable()->after('location');
            $table->time('time_end')->nullable()->after('time_start');
            $table->string('organizer')->nullable()->after('time_end');
            $table->string('contact_person')->nullable()->after('organizer');
            $table->string('registration_link')->nullable()->after('contact_person');
            $table->integer('max_participants')->nullable()->after('registration_link');
            $table->string('status')->default('upcoming')->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn([
                'location', 'time_start', 'time_end', 'organizer',
                'contact_person', 'registration_link', 'max_participants', 'status'
            ]);
        });
    }
};
