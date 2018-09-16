<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tests\DummySheep;

/**
 * DummyContact is an example model simulating a typical user contact.
 */
class DummyContact extends Model
{
    protected $fillable = ['id', 'firstname', 'lastname', 'age', 'phone', 'created_at'];
    
    protected $hidden = ['id'];
    
    protected $dates = ['created_at', 'deleted_at'];

    public function sheeps()
    {
        return $this->hasMany(DummySheep::class);
    }
}
