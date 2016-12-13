<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGasstations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $filePath = __DIR__ . '/../SQL_Dump/gasstation.sql';
        DB::unprepared(file_get_contents($filePath));
        //Schema::table('gasstations', function (Blueprint $table) {
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
        Schema::table('gasstations', function (Blueprint $table) {
            //
        });
    }
}
