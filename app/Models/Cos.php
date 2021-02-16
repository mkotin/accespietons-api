<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cos extends Model
{
    protected $table = 'seance_coss';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'numero_seance', 'date', 'heure', 'lieu', 'statut', 'created_at', 'updated_at'
    ];
}
