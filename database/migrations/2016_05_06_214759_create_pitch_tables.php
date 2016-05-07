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
        $table->boolean('ball');
        $table->boolean('strike');
        $table->timestamps();
      });
      Schema::create('plate_appearance_results', function(Blueprint $table){
        $table->increments('id');
        $table->string('slug')->unique();
        $table->string('description');
        $table->timestamps();
      });
      Schema::create('plate_appearances', function(Blueprint $table){
        $table->increments('id');
        $table->integer('inning');
        $table->integer('outs');
        $table->integer('home_team_runs');
        $table->integer('away_team_runs');
        $table->string('description');
        $table->string('description_es');
        $table->integer('start_tfs');
        $table->integer('batter_id');
        $table->foreign('batter_id')->references('pl_key')->on('piker.players');
        $table->integer('pitcher_id');
        $table->foreign('pitcher_id')->references('pl_key')->on('piker.players');
        $table->integer('plate_appearance_result_id')->unsigned();
        $table->foreign('plate_appearance_result_id')->references('id')->on('plate_appearance_results');
        $table->timestamps();
      });
      Schema::create('pitches', function (Blueprint $table) {
        $table->increments('id');
        $table->string('description');
        $table->string('description_es');
        $table->string('video_url');
        $table->integer('plate_appearance_id')->unsigned();
        $table->foreign('plate_appearance_id')->references('id')->on('plate_appearances');
        $table->integer('pitch_result_id')->unsigned();
        $table->foreign('pitch_result_id')->references('id')->on('pitch_results');
        $table->integer('pitch_type_id')->unsigned();
        $table->foreign('pitch_type_id')->references('id')->on('pitch_types');
        $table->integer('tfs');
        $table->decimal('start_speed', 6,4);
        $table->decimal('end_speed', 6,4);
        $table->decimal('x',6,4);
        $table->decimal('y',6,4);
        $table->decimal('szt',6,4);
        $table->decimal('szb',6,4);
        $table->decimal('pfx_x',7,4);
        $table->decimal('pfx_z',7,4);
        $table->decimal('px',6,4);
        $table->decimal('pz',6,4);
        $table->decimal('x0',6,4);
        $table->integer('y0');
        $table->decimal('z0',6,4);
        $table->decimal('vx0',6,4);
        $table->decimal('vy0',7,4);
        $table->decimal('vz0',6,4);
        $table->decimal('ax',6,4);
        $table->decimal('ay',6,4);
        $table->decimal('az',6,4);
        $table->decimal('break_y',6,4);
        $table->decimal('break_angle',6,4);
        $table->decimal('break_length',6,4);
        $table->integer('nasty');
        $table->decimal('spin_dir',7,4);
        $table->decimal('spin_rate',8,4);
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
      Schema::drop('plate_appearances');
      Schema::drop('plate_appearance_results');
      Schema::drop('pitch_results');
      Schema::drop('pitch_types');
    }
}
