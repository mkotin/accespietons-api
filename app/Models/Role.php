<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'role', 'description',
    ];

    public function users() {
        return $this->hasMany('App\Models\User', 'role_id', 'id');
    }
}
