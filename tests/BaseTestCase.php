<?php

namespace Tests;

use Alariva\ModelMerge\ModelMergeServiceProvider;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class BaseTestCase extends OrchestraTestCase
{

    protected function setUp()
    {
        parent::setUp();

        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        Capsule::schema()->create('dummy_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('age')->nullable();
            $table->string('eyes')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });

        Capsule::schema()->create('dummy_sheep', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dummy_contact_id');
            $table->string('name');
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Load package service provider
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return Alariva\EmailDomainBlacklist\ModelMergeServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [ModelMergeServiceProvider::class];
    }
}
