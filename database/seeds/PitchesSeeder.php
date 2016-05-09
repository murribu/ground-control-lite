<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Pitch;
use App\Models\PitchResult;
use App\Models\PitchType;
use App\Models\PlateAppearance;
use App\Models\PlateAppearanceResult;
use App\Models\Player;

class PitchesSeeder extends Seeder{
  
  private $rss_xml_contents;
  private $rss_xml;
  
  public function run(){
    
    $this->rss_xml_contents = File::get('storage/data/open_414595.xml');
    $this->rss_xml = new SimpleXMLElement($this->rss_xml_contents);
    
    $home_team_runs = 0;
    $away_team_runs = 0;
    for($inning = 1; $inning <= 9; $inning++){
      $inning_xml_contents = File::get('storage/data/inning_'.$inning.'.xml');
      $inning_xml = new SimpleXMLElement($inning_xml_contents);
      $top_atbats = $inning_xml->xpath('/inning/top/atbat');
      $outs = 0;
      while(list( , $at_bat) = each($top_atbats)) {
        $this->store_pa($at_bat, $inning, 'top', $outs, $home_team_runs, $away_team_runs);
        $outs = $at_bat['o'];
        $home_team_runs = $at_bat['home_team_runs'];
        $away_team_runs = $at_bat['away_team_runs'];
      }
      $outs = 0;
      $top_atbats = $inning_xml->xpath('/inning/bottom/atbat');
      while(list( , $at_bat) = each($top_atbats)) {
        $this->store_pa($at_bat, $inning, 'bottom', $outs, $home_team_runs, $away_team_runs);
        $outs = $at_bat['o'];
        $home_team_runs = $at_bat['home_team_runs'];
        $away_team_runs = $at_bat['away_team_runs'];
      }
    }
    
    return;
  }
  
  private function store_pa($at_bat, $inning, $side, $outs, $home_team_runs, $away_team_runs){
    $pa = PlateAppearance::where('guid', $at_bat['play_guid'])->first();
    if (!$pa){
      $pa = new PlateAppearance;
    }
    $pa->guid = $at_bat['play_guid'];
    $pa->inning = $inning;
    $pa->side = $side;
    $pa->outs = $outs;
    $pa->home_team_runs = $home_team_runs;
    $pa->away_team_runs = $away_team_runs;
    $pa->description = $at_bat['des'];
    $pa->description_es = $at_bat['des_es'];
    $pa->start_tfs = $at_bat['start_tfs'];
    $batter = Player::where('pl_mlb', $at_bat['batter'])->first();
    $pa->batter_id = $batter->pl_key;
    $pitcher = Player::where('pl_mlb', $at_bat['pitcher'])->first();
    $pa->pitcher_id = $pitcher->pl_key;
    $pa_result = PlateAppearanceResult::where('slug', $at_bat['event'])->first();
    if (!$pa_result){
      $pa_result = new PlateAppearanceResult;
      $pa_result->slug = $at_bat['event'];
      $pa_result->description = $at_bat['event'];
      $pa_result->description_es = $at_bat['event_es'];
      $pa_result->save();
    }
    $pa->plate_appearance_result_id = $pa_result->id;
    $pa->save();
    $balls = 0;
    $strikes = 0;
    foreach($at_bat->xpath('pitch') as $pitch){
      $p = Pitch::where('svId', $pitch['sv_id'])->first();
      if (!$p){
        $p = new Pitch;
        $p->svId = $pitch['sv_id'];
      }
      $p->balls = $balls;
      $p->strikes = $strikes;
      $video = $this->rss_xml->xpath('/pitchMediaList/pitchMedia[@svId="'.$pitch['sv_id'].'"]/media[@type="FLASH_4500K_1280X720"]');
      $p->video_url = $video[0]['url'][0];
      $p->plate_appearance_id = $pa->id;
      $pitch_result = PitchResult::where('slug', $pitch['des'])->first();
      if (!$pitch_result){
        $pitch_result = new PitchResult;
        $pitch_result->slug = $pitch['des'];
        $pitch_result->description = $pitch['des'];
        $pitch_result->description_es = $pitch['des_es'];
        $pitch_result->save();
      }
      $p->pitch_result_id = $pitch_result->id;
      switch ($pitch_result->slug){
        case "Ball":
        case "Ball In Dirt":
          $balls++;
          break;
        case "Foul (Runner Going)":
        case "Foul Tip":
        case "Foul":
          if ($strikes < 2){
            $strikes++;
          }
          break;
        case "Called Strike":
        case "Swinging Strike":
        case "Swinging Strike (Blocked)":
          $strikes++;
          break;
      }
      $p->last_pitch_of_pa = $at_bat->xpath('pitch')[count($at_bat->xpath('pitch'))-1]['sv_id'] == $pitch['sv_id'];
      $pitch_type = PitchType::where('slug', $pitch['pitch_type'])->first();
      if (!$pitch_type){
        $pitch_type = new PitchType;
        $pitch_type->slug = $pitch['pitch_type'];
        $pitch_type->save();
      }
      $p->pitch_type_id = $pitch_type->id;
      $p->tfs = $pitch['tfs'];
      $p->start_speed = $pitch['start_speed'];
      $p->end_speed = $pitch['end_speed'];
      $p->x = $pitch['x'];
      $p->y = $pitch['y'];
      $p->szt = $pitch['sz_top'];
      $p->szb = $pitch['sz_bot'];
      $p->pfx_x = $pitch['pfx_x'];
      $p->pfx_z = $pitch['pfx_z'];
      $p->px = $pitch['px'];
      $p->pz = $pitch['pz'];
      $p->x0 = $pitch['x0'];
      $p->y0 = $pitch['y0'];
      $p->z0 = $pitch['z0'];
      $p->vx0 = $pitch['vx0'];
      $p->vy0 = $pitch['vy0'];
      $p->vz0 = $pitch['vz0'];
      $p->ax = $pitch['ax'];
      $p->ay = $pitch['ay'];
      $p->az = $pitch['az'];
      $p->break_y = $pitch['break_y'];
      $p->break_angle = $pitch['break_angle'];
      $p->break_length = $pitch['break_length'];
      $p->nasty = $pitch['nasty'];
      $p->spin_dir = $pitch['spin_dir'];
      $p->spin_rate = $pitch['spin_rate'];
      $p->save();
    }
  }
}