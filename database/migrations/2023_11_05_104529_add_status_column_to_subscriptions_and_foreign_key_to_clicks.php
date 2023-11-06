<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Добавление колонки "status" в таблицу "subscriptions"
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->boolean('is_active')->default(true); // Пример: новая колонка с булевым значением
        });

        // Добавление внешнего ключа "subscription_id" в таблицу "clicks"
        Schema::table('clicks', function (Blueprint $table) {
            $table->foreign('subscription_id')->references('id')->on('subscriptions');
        });
    }

    public function down()
    {
        // Откат изменений, если необходимо
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('is_active'); // Удаление колонки "status"
        });

        Schema::table('clicks', function (Blueprint $table) {
            $table->dropForeign(['subscription_id']); // Удаление внешнего ключа
        });
    }
};
