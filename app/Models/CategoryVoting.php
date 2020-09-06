<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class CategoryVoting extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    
    protected $table = "category_voting";
    protected $primaryKey = "id_category";

    public function category_voting()
    {
    	return $this->hasMany(CreateVoting::class);
    }

    public function multi_vote()
    {
    	return $this->hasMany(MultiVote::class);
    }

}
