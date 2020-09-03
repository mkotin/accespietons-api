<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'lname', 'fname', 'email', 'login', 'password', 'fonction', 'role_id', 'structure_id', 'email_verified_at',
        'api_key', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    public function structure() {
        return $this->belongsTo('App\Models\Structure', 'structure_id', 'id');
    }

    public function demandes() {
        return $this->hasMany('App\Models\Demande', 'agent_id', 'id');
    }
}
