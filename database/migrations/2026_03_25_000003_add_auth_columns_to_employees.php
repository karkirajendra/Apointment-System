<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Allows Doctor/Staff login later (role-based auth)
            $table->string('username')->nullable()->unique();
            $table->string('password')->nullable();
            $table->rememberToken()->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['username', 'password', 'remember_token']);
        });
    }
};

