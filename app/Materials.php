<?php


namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class materials extends Model
{
    use Notifiable;

    protected $table = 'materials';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','visible,'
    ];

    public function item()
    {
        return $this->hasMany('App\Item');
    }
}
