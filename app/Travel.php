<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @file file Model where can do operations at travel table of database
 * @name Travel.php
 * @author Juan Sebastiana Maya <jumaya19@gmail.com>
 **/

class Travel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'travel';
    protected $primaryKey = 'travel_id';

    /**
     * The attributes that are more assignable.
     *
     * @var array
     */
    protected $fillable = ['travel_id', 'travel_date', 'country', 'city', 'email'];


    public $timestamps = false;

    /**
     * Get the relationship of travel has many client.
     */
    public function client()
    {        
        return $this->hasMany('App\Client', 'email');
    }    
}
