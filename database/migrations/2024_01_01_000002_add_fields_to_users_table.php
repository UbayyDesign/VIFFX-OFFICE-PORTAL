<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email');
            $table->string('avatar')->nullable()->after('role');
            $table->foreignId('team_id')->nullable()->after('avatar')->constrained()->nullOnDelete();
            $table->string('phone')->nullable()->after('team_id');
            $table->string('position')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('position');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'avatar', 'team_id', 'phone', 'position', 'is_active']);
        });
    }
};
