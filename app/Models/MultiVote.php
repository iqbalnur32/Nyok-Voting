<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class MultiVote extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    
    protected $table = "multi_vote";
    protected $primaryKey = "id_multi";
    public $incrementing = false;

    public function category_voting()
    {
    	return $this->belongsTo(CategoryVoting::class, 'id_category', 'id_category');
    }

}
