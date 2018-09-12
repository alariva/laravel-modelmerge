<?php

namespace Tests;

use Alariva\ModelMerge\ModelMerge;
use Alariva\ModelMerge\Strategies\MergeSimple;
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

    public function test_it_allows_an_external_strategy_class()
    {
        $modelA = DummyContact::make(['firstname' => 'John', 'age' => 33]);
        $modelB = DummyContact::make(['firstname' => 'John', 'lastname' => 'Doe']);

        $strategy = new MergeSimple();

        $modelMerge = new ModelMerge($strategy);
        $modelMerge->setModelA($modelA)->setModelB($modelB);
        $mergedModel = $modelMerge->merge();

        $this->assertEquals($mergedModel->firstname, 'John');
        $this->assertEquals($mergedModel->lastname, 'Doe');
        $this->assertEquals($mergedModel->age, 33);
    }

    public function test_it_verifies_nok_identity_compound_key_before_merge()
    {
        $modelA = DummyContact::make(['firstname' => 'John', 'lastname' => 'Doe', 'age' => 33]);
        $modelB = DummyContact::make(['firstname' => 'John', 'lastname' => 'Other', 'age' => 33, 'phone' => '+1 123 456 789']);

        $modelMerge = new ModelMerge(new MergeSimple());
        $modelMerge->withKey(['firstname', 'lastname', 'age'])->setModelA($modelA)->setModelB($modelB);

        $this->expectException(\Alariva\ModelMerge\Exceptions\ModelsNotDupeException::class);

        $mergedModel = $modelMerge->merge();
    }

    public function test_it_verifies_nok_identity_compound_key_before_merge_passed_as_string()
    {
        $modelA = DummyContact::make(['firstname' => 'John', 'lastname' => 'Doe', 'age' => 33]);
        $modelB = DummyContact::make(['firstname' => 'John', 'lastname' => 'Other', 'age' => 33, 'phone' => '+1 123 456 789']);

        $modelMerge = new ModelMerge(new MergeSimple());
        $modelMerge->withKey('lastname')->setModelA($modelA)->setModelB($modelB);

        $this->expectException(\Alariva\ModelMerge\Exceptions\ModelsNotDupeException::class);

        $mergedModel = $modelMerge->merge();
    }

    public function test_it_verifies_ok_identity_compound_key_before_merge_passed_as_string()
    {
        $modelA = DummyContact::make(['firstname' => 'John', 'lastname' => 'Doe', 'age' => 33]);
        $modelB = DummyContact::make(['firstname' => 'John', 'lastname' => 'Doe', 'age' => 33, 'phone' => '+1 123 456 789']);

        $modelMerge = new ModelMerge(new MergeSimple());
        $modelMerge->withKey('lastname')->setModelA($modelA)->setModelB($modelB);

        $mergedModel = $modelMerge->merge();

        $this->assertEquals($mergedModel->firstname, 'John');
        $this->assertEquals($mergedModel->lastname, 'Doe');
        $this->assertEquals($mergedModel->age, 33);
    }

    public function test_it_saves_the_merged_model()
    {
        $baseModel = DummyContact::create(['firstname' => 'John', 'lastname' => 'Doe', 'age' => 33]);
        $dupeModel = DummyContact::create(['firstname' => 'John', 'lastname' => 'Doer', 'age' => 33, 'phone' => '+1 123 456 789']);

        $modelMerge = new ModelMerge();
        $baseModel = $modelMerge->setBase($baseModel)->setDupe($dupeModel)->unifyOnBase();

        // Merge was correct
        $this->assertEquals($baseModel->firstname, 'John');
        $this->assertEquals($baseModel->lastname, 'Doe');
        $this->assertEquals($baseModel->age, 33);
        $this->assertEquals($baseModel->phone, '+1 123 456 789');

        // Base was saved and dupe was deleted
        $this->assertEquals(true, $baseModel->exists);
        $this->assertEquals(false, $dupeModel->exists);
    }
}
