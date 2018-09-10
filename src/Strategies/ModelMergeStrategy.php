<?php

namespace Alariva\ModelMerge\Strategies;

interface ModelMergeStrategy
{
    public function merge($modelA, $modelB);
}
