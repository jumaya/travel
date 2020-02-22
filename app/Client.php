<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

/**
 * @file file Model where can do operations at client table of database
 * @name Client.php
 * @author Juan Sebastiana Maya <jumaya19@gmail.com>
 **/

class Client extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'client';
    protected $primaryKey = 'client_id';

    /**
     * The attributes that are more assignable.
     *
     * @var array
     */
    protected $fillable = ['client_id', 'first_name', 'last_name', 'email', 'address', 'phone', 'photo'];


    public $timestamps = false;


    /**
     * Relationship has to many with travel table
     *
     * @var array
     */
    public function travel()
    {
        return $this->belongsTo('App\Travel', 'email');
    }


     /**
     * return Clients withe three filter ('first_name', 'last_name', 'email')
     *
     * @return \App\Client
     * @param  string  $name
     */
    public static function filtroClient($name)
    {
        return Client::select('client_id', 'first_name', 'last_name', 'email', 'address', 'phone')
            ->where('first_name', "LIKE", "%$name%")
            ->orWhere('last_name', "LIKE", "%$name%")
            ->orWhere('email', "LIKE", "%$name%")
            ->paginate(15);
    }

    /**
     * return Clients with phone filter
     *
     * @return \App\Client
     * @param  string  $name
     */
    public static function getClientByPhone($name)
    {
        return Client::select('client_id', 'first_name', 'last_name', 'email', 'address', 'phone')
            ->where('phone', "LIKE", "%$name%")->get();
    }


    /**
     * return clients and his travels with client_id filter
     *
     * @return \App\Client
     * @param  string  $id
     */
    public static function getClientAndTravel($id)
    {
        return Client::select(
            'client_id',
            'first_name',
            'last_name',
            'client.email',
            'phone',
            'travel_id',
            'travel_date',
            'country',
            'city'
        )
            ->join('travel', 'travel.email', '=', 'client.email')
            ->where('client_id', '=', $id)
            ->get();
    }
}
