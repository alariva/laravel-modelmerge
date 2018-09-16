<?php

namespace Tests;

use Alariva\ModelMerge\ModelMerge;
use Carbon\Carbon;

class ModelMergeRelationshipsTest extends BaseTestCase
{
    public function test_it_merges_hasmany_relationships()
    {
        $oldestModel = DummyContact::create(['firstname'  => 'John',
                                             'lastname'   => 'Doe',
                                             'age'        => 33,
                                             'phone'      => '+1 123 456 789',
                                             'created_at' => Carbon::now(), ]);
        $newestModel = DummyContact::create(['firstname'  => 'John',
                                             'lastname'   => 'Doe',
                                             'age'        => 33,
                                             'created_at' => Carbon::now()->addDay(), ]);

        $sheepDolly = DummySheep::make(['name' => 'Dolly', 'color' => 'white']);
        $sheepMolly = DummySheep::make(['name' => 'Molly', 'color' => 'gray']);
        $sheepRoberta = DummySheep::make(['name' => 'Roberta', 'color' => 'black']);

        $newestModel->sheeps()->save($sheepDolly);
        $newestModel->sheeps()->save($sheepMolly);
        $newestModel->sheeps()->save($sheepRoberta);

        $modelMerge = new ModelMerge();

        $this->assertEquals($oldestModel->sheeps()->count(), 0);
        $this->assertEquals($newestModel->sheeps()->count(), 3);

        $mergedModel = $modelMerge->withRelationships(['sheeps'])
                                  ->setBase($oldestModel)
                                  ->setDupe($newestModel)
                                  ->merge();

        // Merge was correct
        $this->assertEquals($mergedModel->firstname, 'John');
        $this->assertEquals($mergedModel->lastname, 'Doe');
        $this->assertEquals($mergedModel->age, 33);
        $this->assertEquals($mergedModel->phone, '+1 123 456 789');

        // Child models were transferred
        $this->assertEquals($oldestModel->sheeps()->count(), 3);
        $this->assertEquals($newestModel->sheeps()->count(), 0);

        // And total count of child models was preserved
        $this->assertEquals(DummySheep::count(), 3);
    }
}
