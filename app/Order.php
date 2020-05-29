<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Notifiable;
    use SoftDeletes;


    protected $table = 'objednavka';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pouzivatel_id', 'nazov_objednavky', 'polozky','popis','pocet','poznamka','status_id','dtm_vytvorenia','dtm_ukoncenia','tracking_num','faktura',
    ];

 /*   public function user()
    {
        return $this->hasMany('App\User');
    }*/

    public function user()
    {
        return $this->belongsTo('App\User', 'pouzivatel_id')->withTrashed();
    }

    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id');
    }

    public function items()
    {
        return $this->hasMany('App\Item', 'order_id','id');
    }

    public function scopeFilter($query, $params)
    {
        if ( isset($params['customer']) && trim($params['customer'] !== '') ) {
            $query->where('pouzivatel_id', 'LIKE', trim($params['customer']) . '%');
        }

        if ( isset($params['orderName']) && trim($params['orderName']) !== '' )
        {
            $query->where('nazov_objednavky', '=',trim($params['orderName']));
        }

        if ( isset($params['status']) && trim($params['status']) !== '' )
        {
            $query->where('status_id', trim($params['status']));
        }

        if ( isset($params['confiFrom']) && trim($params['confiFrom']) !== '' )
        {
            $query->where('dtm_vytvorenia', '>=',trim($params['confiFrom']));
        }

        if ( isset($params['confiTo']) && trim($params['confiTo']) !== '' )
        {
            $query->where('dtm_vytvorenia', '<=',trim($params['confiTo']));
        }

        if ( isset($params['complFrom']) && trim($params['complFrom']) !== '' )
        {
            $query->where('dtm_ukoncenia', '>=',trim($params['complFrom']));
        }

        if ( isset($params['complTo']) && trim($params['complTo']) !== '' )
        {
            $query->where('dtm_ukoncenia', '<=',trim($params['complTo']));
        }

        if ($params['origin']=="AOrepositoryCustomer") {
            $query->where('visible', 1)->where('status_id', '<', 7)->where('pouzivatel_id', auth()->user()->id);
        }elseif ($params['origin']=="COrepositoryCustomer"){
            $query->where('visible', 1)->where('status_id', '>', 6)->where('pouzivatel_id', auth()->user()->id);
        }
        elseif($params['origin']=="AOrepository") {
            $query->where('visible', 1)->where('status_id', '<', 7);
        }elseif ($params['origin']=="COrepository"){
            $query->where('visible', 1)->where('status_id', '>', 6);
        }

        return $query;
    }


}
