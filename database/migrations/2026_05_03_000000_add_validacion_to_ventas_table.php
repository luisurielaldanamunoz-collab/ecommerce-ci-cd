<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->boolean('validada')->default(false)->after('ticket');
            $table->foreignId('validada_por')->nullable()->after('validada')->constrained('usuarios')->nullOnDelete();
            $table->timestamp('validada_en')->nullable()->after('validada_por');
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('validada_por');
            $table->dropColumn(['validada', 'validada_en']);
        });
    }
};
