<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlateAppearance extends Model {
	protected $table = 'plate_appearances';
  
  public function pitcher(){
    return $this->belongsTo('App\Models\Player', 'pitcher_id');
  }
  public function batter(){
    return $this->belongsTo('App\Models\Player', 'batter_id');
  }
  public function result(){
    return $this->belongsTo('App\Models\PlateAppearanceResult', 'plate_appearance_result_id');
  }
}