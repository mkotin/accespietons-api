<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Usager extends Model
{
    protected $table = 'users';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'id', 'nom', 'prenoms', 'date_naiss', 'lieu_naiss', 'nationalite', 'photo', 'adresse', 'telephone', 'email', 'fonction', 'num_piece_identite', 'num_carte_professionelle', 'num_certificat_prise_service', 'temps_acces', 'type_acces', 'actif', 'date_ajout', 'statut', 'structure_id', 'badge_id', 'created_at', 'updated_at'
    ];
}