<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class CreateVoting extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    
    protected $table = "create_voting";
    protected $primaryKey = "id_voting";
    protected $fillable = ['title', 'img', 'description'];

    public function category_voting()
    {
    	return $this->belongsTo(CategoryVoting::class, 'id_category', 'id_category');
    }

    public function jawaban_voting()
    {
    	return $this->belongsTo(JawabanVoting::class, 'id_voting', 'id_voting');
    }

    public function users()
    {
        return $this->belongsTo(Users::class, 'id_users', 'id_users');
    }

    public function created_voting()
    {
        return $this->hashMany(JawabanVoting::class);
    }

}
