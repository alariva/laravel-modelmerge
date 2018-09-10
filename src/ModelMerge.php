<?php

namespace Alariva\ModelMerge;

use Illuminate\Database\Eloquent\Model;

class ModelMerge
{
    /**
     * First model
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $modelA;

    /**
     * Second model
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $modelB;

    /**
     * Set model A
     * 
     * @param Model $model
     *
     * @return  $this
     */
    public function setModelA(Model $model)
    {
        $this->modelA = $model;

        return $this;
    }

    /**
     * Set model B
     * 
     * @param Model $model
     *
     * @return  $this
     */
    public function setModelB(Model $model)
    {
        $this->modelB = $model;

        return $this;
    }

    /**
     * Executes the merge for A and B Models
     * 
     * @return Illuminate\Database\Eloquent\Model The model A with merged attributes from model B
     */
    public function merge()
    {
        $dataA = $this->modelA->toArray();
        $dataB = $this->modelB->toArray();

        $dataMerge = array_merge($dataA, $dataB);

        $this->modelA->fill($dataMerge);

        return $this->modelA;
    }
}
