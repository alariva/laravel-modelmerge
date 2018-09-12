<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;

/**
 * DummyContact is an example model simulating a typical user contact.
 */
class DummyContact extends Model
{
    protected $fillable = ['firstname', 'lastname', 'age', 'phone'];

    public function save(array $options = [])
    {
        $this->exists = true;
        $this->wasRecentlyCreated = true;
    }

    public function delete()
    {
        $this->exists = false;
        $this->wasRecentlyCreated = false;
    }
}
