<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValuesToPridataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $filePath = __DIR__ . '/../SQL_Dump/pricedatas.sql';
        DB::unprepared(file_get_contents($filePath));
        //Schema::table('pricedata', function (Blueprint $table) {
            //
        //});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pricedata', function (Blueprint $table) {
            //
        });
    }
}
