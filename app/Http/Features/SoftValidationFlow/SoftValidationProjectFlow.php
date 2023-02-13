<?php

namespace App\Http\Features\SoftValidationFlow;

use App\Scopes\ValidationFlowScope;

trait SoftValidationProjectFlow
{
    /**
     * Indicates if the model is currently force query builder to return
     * unpproved projects too.
     *
     * @author Edilson Mucanze
     * @var bool
     */
    protected $forceUnpprovedProjects = false;

    /**
     * Boot the soft validation project flow trait for a model.
     *
     * @return void
     */
    public static function bootSoftValidationProjectFlow()
    {
        static::addGlobalScope(new ValidationFlowScope);
    }


    /**
     * Get the name of the "validated on" column.
     *
     * @return string
     */
    public function getValidatedOnColumn()
    {
        return 'validated_on';
    }

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedValidatedOnColumn()
    {
        return $this->qualifyColumn($this->getValidatedOnColumn());
    }
}
