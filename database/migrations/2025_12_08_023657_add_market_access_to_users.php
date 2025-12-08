<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Se TRUE: Vê mercado público + compartilhados
            // Se FALSE: Só vê compartilhados (Modo Carteira Fechada)
            $table->boolean('can_view_all_properties')->default(true)->after('developer_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('can_view_all_properties');
        });
    }
};