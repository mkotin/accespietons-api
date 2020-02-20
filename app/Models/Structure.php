<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $table = 'structures';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nom', 'numero_accreditation', 'numero_agrement', 'telephone', 'email', 'siege', 'sigle', 'ifu', 'responsable',
    ];

    public function users() {
        return $this->hasMany('App\Models\User', 'structure_id', 'id');
    }

}
