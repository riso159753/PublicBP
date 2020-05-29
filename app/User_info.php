<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User_info extends Authenticatable
{
    use Notifiable;

    protected $table = 'pouzivatel_info';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pouzivatel_id', 'meno', 'krajina','telefon','rola',
    ];



}
