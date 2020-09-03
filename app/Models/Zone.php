<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zones';
    protected $fillable = ['id', 'code', 'libelle', 'description', 'couleur', 'tarif', 'active', 'created_at', 'updated_at'];
}
