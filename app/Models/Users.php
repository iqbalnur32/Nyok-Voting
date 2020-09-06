<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    
    protected $table = "users_voting";
    protected $primaryKey = "id_users";
    protected $fillable = ['username', 'email', 'password', 'level_id', 'status', 'last_login'];

    public function jawaban_voting()
    {
        return $this->hashMany(JawabanVoting::class);
    }

    public function users()
    {
    	return $this->hashMany(CreateVoting::class);
    }
}