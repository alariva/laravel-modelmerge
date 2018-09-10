<?php

namespace Alariva\ModelMerge\Strategies;

use Alariva\ModelMerge\Strategies\ModelMergeStrategy;

class MergeSimple implements ModelMergeStrategy
{
    public function merge($modelA, $modelB)
    {
        $dataA = $modelA->toArray();
        $dataB = $modelB->toArray();

        $dataMerge = array_merge($dataA, $dataB);

        $modelA->fill($dataMerge);

        return $modelA;
    }
}
