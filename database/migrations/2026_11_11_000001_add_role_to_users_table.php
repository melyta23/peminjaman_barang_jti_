<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password'); // admin, petugas, user
            $table->string('nim_nip')->nullable()->after('role');
            $table->string('no_hp')->nullable()->after('nim_nip');
            $table->string('prodi')->nullable()->after('no_hp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nim_nip', 'no_hp', 'prodi']);
        });
    }
};

