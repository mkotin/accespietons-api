<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadgeType extends Model
{
    protected $table = 'badge_types';
    protected $fillable = ['id', 'code', 'libelle', 'couttc', 'created_at', 'updated_at'];
}
