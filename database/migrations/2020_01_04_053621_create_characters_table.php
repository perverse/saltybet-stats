<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /*
    public name: string;
	public wins: any[];
	public losses: any[];
	public winTimes: number[];
	public lossTimes: number[];
	public odds: number[];
	public crowdFavor: number[];
	public illumFavor: number[];
	public tiers: string[];
	public totalFights: any[];
    */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->index()->default(0);
            $table->integer('wins')->index()->default(0);
            $table->integer('losses')->index()->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
