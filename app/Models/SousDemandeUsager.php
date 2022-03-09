<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SousDemandeUsager extends Model
{
    protected $table = 'sous_demandes_usagers';
    protected $fillable = ['id', 'usager_id', 'demande_id', 'autorise', 'type_acces', 'temps_acces', 'montant', 'impression_badge_id', 'badge_type_id', 'zone_id', 'couttc', 'created_at', 'updated_at'];
}
