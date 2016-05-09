<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNormalizationColumnsToPitchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('pitches', function($table) {
        $table->boolean('last_pitch_of_pa');
        $table->integer('balls');
        $table->integer('strikes');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('pitches', function($table) {
        $table->dropColumn('last_pitch_of_pa');
        $table->dropColumn('balls');
        $table->dropColumn('strikes');
      });
    }
}
