<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;

/**
 * DummyContact is an example model simulating a typical user contact.
 */
class DummyContact extends Model
{
    protected $fillable = ['firstname', 'lastname', 'age'];
}
