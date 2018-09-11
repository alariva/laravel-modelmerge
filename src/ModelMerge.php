<?php

namespace Alariva\ModelMerge;

use Alariva\ModelMerge\Exceptions\ModelsNotDupeException;
use Alariva\ModelMerge\Strategies\MergeSimple;
use Alariva\ModelMerge\Strategies\ModelMergeStrategy;
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
     * Merge strategy implementation.
     * 
     * @var [type]
     */
    protected $strategy;

    /**
     * ID Keys
     * 
     * @var array
     */
    protected $keys = null;

    public function __construct($strategy = null)
    {
        $this->useStrategy($strategy);
    }

    /**
     * Pick a strategy class for merge operation.
     * 
     * @param  Alariva\ModelMerge\Strategies\ModelMergeStrategy $strategy   Instance of a merger strategy
     * 
     * @return $this
     */
    public function useStrategy(ModelMergeStrategy $strategy = null)
    {
        $this->strategy = $strategy === null ? new MergeSimple() : $strategy;

        return $this;
    }

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
     * Specify a compound key to match models and verify identity.
     * 
     * @param  string|array $keys Keys that make the model identifiable
     * 
     * @return $this
     */
    public function withKey($keys)
    {
        if (is_array($keys)) {
            $this->keys = $keys;
        }

        if (is_string($keys)) {
            $this->keys = [$keys];
        }

        return $this;
    }

    /**
     * Executes the merge for A and B Models
     * 
     * @return Illuminate\Database\Eloquent\Model The model A with merged attributes from model B
     */
    public function merge()
    {
        $this->validateKeys();

        return $this->strategy->merge($this->modelA, $this->modelB);
    }

    protected function validateKeys()
    {
        if ($this->keys === null) {
            return;
        }

        $dataA = $this->modelA->only($this->keys);
        $dataB = $this->modelB->only($this->keys);

        if ($dataA != $dataB) {
            throw new ModelsNotDupeException('Models are not dupes', 1);
        }
    }
}
