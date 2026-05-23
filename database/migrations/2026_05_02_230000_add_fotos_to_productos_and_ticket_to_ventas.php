<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->json('fotos')->nullable()->after('existencia');
        });

        Schema::table('ventas', function (Blueprint $table) {
            $table->string('ticket')->nullable()->after('total');
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn('ticket');
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('fotos');
        });
    }
};
