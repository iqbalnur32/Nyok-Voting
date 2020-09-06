<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class JawabanMulti extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    
    protected $table = "jwbn_multi_vote";
    public $incrementing = false;

}
