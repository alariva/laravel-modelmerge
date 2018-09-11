<?php

namespace Tests;

use Alariva\ModelMerge\ModelMerge;
use Alariva\ModelMerge\Strategies\MergeSimple;
use Illuminate\Database\Eloquent\Model;

class ModelMergeStrategiesTest extends BaseTestCase
{
    public function test_simple_merge_strategy()
    {
        $modelA = DummyContact::make(['firstname' => 'John', 'age' => 33]);
        $modelB = DummyContact::make(['firstname' => 'John', 'lastname' => 'Doe']);

        $modelMerge = new ModelMerge(new MergeSimple);
        $modelMerge->setModelA($modelA)->setModelB($modelB);
        $mergedModel = $modelMerge->merge();

        $this->assertEquals($mergedModel->firstname, 'John');
        $this->assertEquals($mergedModel->lastname, 'Doe');
        $this->assertEquals($mergedModel->age, 33);
    }
}
