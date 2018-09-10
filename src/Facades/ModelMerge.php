<?php

namespace Alariva\ModelMerge\Facades;

use Illuminate\Support\Facades\Facade;

class ModelMerge extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'modelmerge';
    }
}
