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
            $table->enum('role', ['admin', 'developer', 'client'])->default('client')->after('email');
            // ADICIONADO 'pending' NA LISTA ABAIXO
            $table->enum('status', ['active', 'inactive', 'suspended', 'pending'])->default('active')->after('role');
            $table->timestamp('access_expires_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'access_expires_at']);
        });
    }
};