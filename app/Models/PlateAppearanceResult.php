<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlateAppearanceResult extends Model {
	protected $table = 'plate_appearance_results';
  
  public function plate_appearances(){
    return $this->hasMany('App\Models\PlateAppearance');
  }
}