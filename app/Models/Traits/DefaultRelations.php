<?php

namespace App\Models\Traits;

/**
 * Trait to eager load a group  of relations
 *
 * @mixin \Eloquent
 */
trait DefaultRelations
{
    /**
     * Get the list of relations to be eager loaded
     *
     * @return array
     */
    protected static function getDefaultRelations()
    {
        return defined('static::RELATIONS') ? static::RELATIONS : [];
    }

    /**
     * Eager load default relations on query
     *
     * @param array
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withDefault($with = [])
    {
        return static::query()->with(array_merge(static::getDefaultRelations(), $with));
    }

    /**
     * Eager load default relations
     *
     * @param array
     * @return \App\Models\Traits\DefaultRelations
     */
    public function loadDefault($with = [])
    {
        return $this->load(array_merge(static::getDefaultRelations(), $with));
    }
}
