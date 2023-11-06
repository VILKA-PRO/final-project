<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedAtToOffersTable extends Migration
{
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->softDeletes(); // Это добавит столбец `deleted_at`
        });
    }

    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Это удалит столбец `deleted_at`
        });
    }
}
