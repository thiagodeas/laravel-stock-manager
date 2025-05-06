<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->enum('reason', ['Compra', 'Devolução de Venda', 'Ajuste', 'Troca', 'Doação/Bonificação'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->string('reason')->change();
        });
    }
};
