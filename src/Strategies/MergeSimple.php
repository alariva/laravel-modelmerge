<?php

namespace Alariva\ModelMerge\Strategies;

use Alariva\ModelMerge\Strategies\ModelMergeStrategy;

class MergeSimple implements ModelMergeStrategy
{
    public function merge($modelA, $modelB)
    {
        $dataA = $modelA->toArray();
        $dataB = $modelB->toArray();

        $dataMerge = array_merge($dataB, $dataA);

        $modelA->fill($dataMerge);

        return $modelA;
    }
}
