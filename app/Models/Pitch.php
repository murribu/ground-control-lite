<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pitch extends Model {
	protected $table = 'pitches';
  
  public function plate_appearance(){
    return $this->belongsTo('App\Models\PlateAppearance');
  }
  
  public function result(){
    return $this->belongsTo('App\Models\PitchResult', 'pitch_result_id');
  }
  
  public function type(){
    return $this->belongsTo('App\Models\PitchType');
  }
}