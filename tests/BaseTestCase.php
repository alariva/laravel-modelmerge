<?php

namespace Tests;

use Alariva\ModelMerge\ModelMergeServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class BaseTestCase extends OrchestraTestCase
{
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
