<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->enum('status', ['draft', 'pending_review', 'active', 'negotiating', 'sold', 'rented'])
                  ->default('draft')
                  ->after('images');
        });

        Schema::create('property_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('granted_by')->constrained('users');
            $table->timestamps();

            $table->unique(['property_id', 'user_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('developer_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['developer_id']);
            $table->dropColumn('developer_id');
        });

        Schema::dropIfExists('property_access');

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('properties', function (Blueprint $table) {
            $table->enum('status', ['draft', 'pending', 'published', 'sold', 'rented'])->default('draft');
        });
    }
};