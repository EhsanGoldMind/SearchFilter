<?php

namespace App\Criteria;

class StatusCriteria
{
    public function apply($query, $status) {
        $query->where('status', $status);
    }
}
