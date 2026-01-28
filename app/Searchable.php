<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

/**
 * you can call this from any models just put after modal name: use Searchable;,
 * you have to way to pass the Searchable fields:
 *
 * Searchable attributes
 * @return string[]
 *1- public $searchable = ['name', 'email'];//her you can add all fields you want
 *
 * or
 *
 *2- public static function searchable()
 * {
 *  return ['name', 'email'];//her you can add all fields you want
 *  }
 * more info
 * https://echebaby.com/blog/2021-02-13-searchable-trait-to-search-in-multiple-columns-with-laravel/
 */
trait Searchable
{
    /**
     * Scope a query to search for term in the attributes
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopeSearch($query)
    {
        [$searchTerm, $attributes] = $this->parseArguments(func_get_args());
        if (!$searchTerm || !$attributes) {
            return $query;
        }

        return $query->where(function (Builder $query) use ($searchTerm, $attributes) {
            foreach ($attributes as $attribute) {
                $query->when(
                    str_contains($attribute, '.'),
                    function (Builder $query) use ($searchTerm, $attribute) {
                        [$relationName, $relationAttribute] = explode('.', $attribute);

                        $query->orWhereHas($relationName, function (Builder $query) use ($searchTerm, $relationAttribute) {
                            $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                        });
                    },
                    function (Builder $query) use ($searchTerm, $attribute) {
                        $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                    }
                );
            }
        });
    }

    /**
     * Parse search scope arguments
     *
     * @param array $arguments
     * @return array
     */
    private function parseArguments(array $arguments)
    {
        $args_count = count($arguments);

        switch ($args_count) {
            case 1:
                return [request(config('searchable.key')), $this->searchableAttributes()];
                break;

            case 2:
                return is_string($arguments[1])
                    ? [$arguments[1], $this->searchableAttributes()]
                    : [request(config('searchable.key')), $arguments[1]];
                break;

            case 3:
                return is_string($arguments[1])
                    ? [$arguments[1], $arguments[2]]
                    : [$arguments[2], $arguments[1]];
                break;

            default:
                return [null, []];
                break;
        }
    }

    /**
     * Get searchable columns
     *
     * @return array
     */
    public function searchableAttributes()
    {
        if (method_exists($this, 'searchable')) {
            return $this->searchable();
        }

        return property_exists($this, 'searchable') ? $this->searchable : [];
    }
}
