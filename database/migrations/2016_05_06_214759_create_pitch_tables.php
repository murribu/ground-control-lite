<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePitchTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pitch_types', function(Blueprint $table){
        $table->increments('id');
        $table->string('slug')->unique();
        $table->string('description');
        $table->timestamps();
      });
        Schema::create('pitch_results', function(Blueprint $table){
          $table->increments('id');
          $table->string('slug')->unique();
          $table->string('description');
        $table->timestamps();
        });
      Schema::create('plate_appearance_results', function(Blueprint $table){
        $table->increments('id');
        $table->string('slug')->unique();
        $table->string('description');
        $table->timestamps();
      });
      Schema::create('pitches', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('batter_id');
        $table->foreign('batter_id')->references('pl_key')->on('piker.players');
        $table->integer('pitcher_id');
        $table->foreign('pitcher_id')->references('pl_key')->on('piker.players');
        $table->integer('pitch_result_id')->unsigned();
        $table->foreign('pitch_result_id')->references('id')->on('pitch_results');
        $table->integer('pitch_type_id')->unsigned();
        $table->foreign('pitch_type_id')->references('id')->on('pitch_types');
        $table->integer('tfs');
        $table->decimal('x',6,4);
        $table->decimal('y',6,4);
        $table->decimal('szt',6,4);
        $table->decimal('szb',6,4);
        $table->decimal('x0',6,4);
        $table->integer('y0');
        $table->decimal('z0',6,4);
        $table->decimal('vx0',6,4);
        $table->decimal('vy0',7,4);
        $table->decimal('vz0',6,4);
        $table->decimal('ax',6,4);
        $table->decimal('ay',6,4);
        $table->decimal('az',6,4);
        $table->decimal('start_speed', 6,4);
        $table->string('video_url');
        $table->string('svId');
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
      Schema::drop('pitches');
      Schema::drop('plate_appearance_results');
      Schema::drop('pitch_results');
      Schema::drop('pitch_types');
    }
}
