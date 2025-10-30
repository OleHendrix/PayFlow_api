<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait CanLoadRelationship
{
  public function loadRelationships(Model|Builder|QueryBuilder $for)
  {
    $relations = $this->relations;
    $include = request()->query('include');

    if (!$include) {
      return $for;
    }

    $includes = array_map('trim', explode(',', $include));

    foreach ($relations as $relation) {
      if (in_array($relation, $includes)) {
        if ($for instanceof Model) {
          $for->load($relation);
        } else {
          $for->with($relation);
        }
      }
    }

    return $for;
  }
}