<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalisationDemande extends Model
{
    protected $table = 'journalisation_demande';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'demande_id' ,'title', 'description', 'created_at', 'updated_at'
    ];
}
