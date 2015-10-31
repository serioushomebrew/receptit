<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonusClient extends Model
{

    protected $table = 'bonus_client';
    protected $fillable = ['client_id','card_number'];
    public $timestamps = false;
}
