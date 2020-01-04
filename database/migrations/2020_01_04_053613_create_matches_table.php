<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*

    { data: "c1", title: "Character 1" },
    { data: "c2", title: "Character 2" },
    { data: "w", title: "Winner" },
    { data: "sn", title: "Strategy" },
    { data: "pw", title: "Prediction" },
    { data: "t", title: "Tier" },
    { data: "m", title: "Mode" },
    { data: "o", title: "Odds" },
    { data: "ts", title: "Time" },
    { data: "cf", title: "Crowd favor" },
    { data: "if", title: "Illum favor" },
    { data: "dt", title: "Date" },

*/

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('character_a_id')->index();
            $table->integer('character_b_id')->index();
            $table->integer('character_winner_id')->index();
            $table->integer('character_crowd_favour_id')->index();
            $table->integer('character_illum_favour_id')->index();
            $table->integer('character_a_bet_return');
            $table->integer('character_b_bet_return');
            $table->string('strategy');
            $table->string('prediction');
            $table->string('tier');
            $table->string('mode');
            $table->string('odds');
            $table->integer('time');
            $table->dateTime('date');
            $table->string('hash')->index();

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
        Schema::dropIfExists('matches');
    }
}
