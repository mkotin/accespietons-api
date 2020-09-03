<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticData extends Model
{
    protected $table = 'static_data';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'code', 'value',
    ];
}
