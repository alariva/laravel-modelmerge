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

    public function test_it_aborts_merge_on_belong_to_diverge()
    {
        $shepherdJohn = DummyContact::create(['firstname'  => 'John',
                                              'lastname'   => 'Doe',]);
        $shepherdMatt = DummyContact::create(['firstname'  => 'Matt',
                                              'lastname'   => 'Power',]);

        $sheepWhiteDolly = DummySheep::make(['name' => 'Dolly', 'color' => 'white']);
        $sheepBlackDolly = DummySheep::make(['name' => 'Dolly', 'color' => 'black']);

        $shepherdJohn->sheeps()->save($sheepWhiteDolly);
        $shepherdMatt->sheeps()->save($sheepBlackDolly);

        $modelMerge = new ModelMerge();

        $this->assertEquals($shepherdJohn->sheeps()->count(), 1);
        $this->assertEquals($shepherdMatt->sheeps()->count(), 1);

        $this->expectException(\Alariva\ModelMerge\Exceptions\ModelsBelongToDivergedParentsException::class);

        $mergedModel = $modelMerge->belongsTo('owner')
                                  ->setBase($sheepWhiteDolly)
                                  ->setDupe($sheepBlackDolly)
                                  ->unifyOnBase();

        // Relationships were untouched
        $this->assertEquals($shepherdJohn->sheeps()->count(), 1);
        $this->assertEquals($shepherdMatt->sheeps()->count(), 1);

        // And total count of child models was preserved
        $this->assertEquals(DummySheep::count(), 2);
    }

    public function test_it_merges_on_belong_to_same_parent()
    {
        $shepherd = DummyContact::create(['firstname'  => 'John',
                                          'lastname'   => 'Doe',]);

        $sheepBaseDolly = DummySheep::make(['name' => 'Dolly', 'color' => 'white']);
        $sheepDupeDolly = DummySheep::make(['name' => 'Dolly', 'color' => 'white']);

        $shepherd->sheeps()->save($sheepBaseDolly);
        $shepherd->sheeps()->save($sheepDupeDolly);

        $modelMerge = new ModelMerge();

        $this->assertEquals($shepherd->sheeps()->count(), 2);

        $mergedModel = $modelMerge->belongsTo('owner')
                                  ->setBase($sheepBaseDolly)
                                  ->setDupe($sheepDupeDolly)
                                  ->unifyOnBase();

        // Merge was correct
        $this->assertEquals($mergedModel->name, 'Dolly');
        $this->assertEquals($mergedModel->color, 'white');
        $this->assertEquals($mergedModel->owner->id, $shepherd->id);

        // Relationships were untouched
        $this->assertEquals($shepherd->sheeps()->count(), 1);

        // And total count of child models was preserved
        $this->assertEquals(DummySheep::count(), 1);
    }
}
