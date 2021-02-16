<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Inviter extends Model
{
    protected $table = 'inviter';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'participe_cos', 'participe_structure', 'seance_cos_id', 'membre_cos_id', 'structure_id', 'created_at', 'updated_at'
    ];
}
