<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Usager extends Model
{
    protected $table = 'usagers';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nom', 'prenoms', 'date_naiss', 'lieu_naiss', 'nationalite', 'photo', 'adresse', 'telephone', 'email', 'fonction', 'num_piece_identite', 'num_carte_professionelle', 'num_certificat_prise_service', 'temps_acces', 'type_acces', 'actif', 'date_ajout', 'status', 'structure_id', 'badge_type_id', 'zone_id', 'created_at', 'updated_at'
    ];

    public function demandes() {
        return $this->belongsToMany('App\Models\Demande', 'sous_demandes_usagers', 'demande_id', 'usager_id');
    }
}
