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
        Schema::table('clicks', function (Blueprint $table) {
            // Добавляем колонку для подсчета кликов
            $table->integer('click_count')->default(1); // По умолчанию 1 клик

            // Добавляем колонку для стоимости за клик
            $table->decimal('click_cost', 8, 2); // Пример для стоимости с двумя знаками после запятой
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clicks', function (Blueprint $table) {
            // Опционально: в методе down можно определить откат миграции, если это необходимо
            $table->dropColumn('click_count');
            $table->dropColumn('click_cost');
        });
    }
};
