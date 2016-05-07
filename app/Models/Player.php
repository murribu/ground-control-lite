<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model {
	protected $table = 'piker.players';
  protected $primaryKey = 'pl_key';
}