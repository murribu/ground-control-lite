<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Auth;
use DB;
use Response;
use Redirect;
use Session;

use App\Models\Pitch;
use App\Models\PlateAppearance;
use App\Models\Player;

class GCLController extends Controller {
    
  function getPlayers(){
    $players = Player::whereRaw('pl_key in (select batter_id from plate_appearances union all select pitcher_id from plate_appearances)')
      ->orderBy('pl_lname')
      ->orderBy('pl_fname')
      ->get();
    return array(
      'items' => $players,
      'total_count' => count($players)
    );
  }
  
  function getPitchers(){
    $players = Player::whereRaw('pl_key in (select pitcher_id from plate_appearances)')
      ->where(function($query){
        $query->whereRaw('pl_fname like ?', array('%'.Input::get('q').'%'));
        $query->orWhereRaw('pl_lname like ?', array('%'.Input::get('q').'%'));
      })
      ->selectRaw('pl_key id, concat(pl_fname, \' \', pl_lname) name')
      ->orderBy('pl_lname')
      ->orderBy('pl_fname')
      ->get();
    return array(
      'items' => $players,
      'total_count' => count($players)
    );
  }
  
  function getBatters(){
    $players = Player::whereRaw('pl_key in (select batter_id from plate_appearances)')
      ->where(function($query){
        $query->whereRaw('pl_fname like ?', array('%'.Input::get('q').'%'));
        $query->orWhereRaw('pl_lname like ?', array('%'.Input::get('q').'%'));
      })
      ->selectRaw('pl_key id, concat(pl_fname, \' \', pl_lname) name')
      ->orderBy('pl_lname')
      ->orderBy('pl_fname')
      ->get();
    return array(
      'items' => $players,
      'total_count' => count($players)
    );
  }
  
  function getPlayer($id){
    $player = Player::find($id);
    return $player;
  }
  
  function getPitches(){
    $pitches = Pitch::with('result','plate_appearance','plate_appearance.pitcher','plate_appearance.batter')
      ->get();
    return $pitches;
  }
  
  function getPlateAppearances(){
    $plate_appearances = PlateAppearance::with('pitcher', 'batter', 'pitches', 'pitches.result', 'result')
      ->get();
      
    return $plate_appearances;
  }
}