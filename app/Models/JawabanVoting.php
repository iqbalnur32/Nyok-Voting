<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class JawabanVoting extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    
    protected $table = "jawaban_voting";
    protected $primaryKey = "id_jawaban";
    protected $fillable = ['nama_lengkap', 'description', 'id_opsi'];

    public function jawaban_voting()
    {
    	return $this->hashMany(CreateVoting::class);
    }

    public function jawaban_voting_users()
    {
        return $this->belongsTo(Users::class, 'id_users', 'id_users');
    }

    public function created_voting()
    {
        return $this->belongsTo(CreateVoting::class, 'id_voting', 'id_voting');
    }

}
