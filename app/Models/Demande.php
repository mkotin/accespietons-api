<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $table = 'demandes';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'ref', 'date_retrait','date_soumission','statut','niveau_acces','montant','responsable','objet_demande', 'nbre_usagers_accepte', 'montant_accepte', 'verifiee', 'structure_id','reglement_demande_id','seance_cos_id', 'agent_id', 'created_at','updated_at'
    ];

    public function usagers() {
        return $this->belongsToMany('App\Models\Usager', 'sous_demandes_usagers', 'demande_id', 'usager_id')->withPivot('autorise', 'type_acces', 'temps_acces');
    }

    public function structure() {
        return $this->belongsTo('App\Models\Structure', 'structure_id', 'id');
    }

    public function cos() {
        return $this->belongsTo('App\Models\Cos', 'seance_cos_id', 'id');
    }
}
