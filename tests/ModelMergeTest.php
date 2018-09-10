<?php

namespace Tests;

use Alariva\ModelMerge\ModelMerge;
use Illuminate\Database\Eloquent\Model;

class ModelMergeTest extends BaseTestCase
{
    public function test_it_returns_a_valid_model()
    {
        $modelA = DummyContact::make(['firstname' => 'John']);
        $modelB = DummyContact::make(['firstname' => 'John', 'lastname' => 'Doe']);

        $modelMerge = new ModelMerge();
        $modelMerge->setModelA($modelA)->setModelB($modelB);
        $mergedModel = $modelMerge->merge();

        $this->assertInstanceOf(Model::class, $mergedModel, 'Merged model should extend an Eloquent Model');
    }

    public function test_it_performs_a_valid_merge()
    {
        $modelA = DummyContact::make(['firstname' => 'John', 'age' => 33]);
        $modelB = DummyContact::make(['firstname' => 'John', 'lastname' => 'Doe']);

        $modelMerge = new ModelMerge();
        $modelMerge->setModelA($modelA)->setModelB($modelB);
        $mergedModel = $modelMerge->merge();

        $this->assertEquals($mergedModel->firstname, 'John');
        $this->assertEquals($mergedModel->lastname, 'Doe');
        $this->assertEquals($mergedModel->age, 33);
    }
}
