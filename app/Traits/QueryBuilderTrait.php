<?php

namespace App\Traits;

trait QueryBuilderTrait
{
    public function scopeGetOrPaginate($query, $paginate, $per_page)
    {
        return $paginate == 'true' ? $query->simplePaginate($per_page) : $query->get();
    }
}
