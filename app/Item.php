<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Item extends Model
{
    use Notifiable;

    protected $table = 'items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id','product','person','material','trim','sidePanel','panel','zip','collar','size','number','visible','preview',
    ];

    public function item()
    {
        return $this->belongsTo('App\Order','order_id')->withTrashed();
    }
    public function materials()
    {
        return $this->belongsTo('App\Materials', 'material');
    }


}
