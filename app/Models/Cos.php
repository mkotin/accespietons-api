<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cors extends Model
{
    protected $table = 'seance_cosss';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'numero_seance', 'date_debut', 'date_fin', 'statut', 'created_at', 'updated_at'
    ];
}
