<?php

namespace App\Criteria;

class CustomerCriteria
{

    public function apply($query, $identifier) {


        $query->whereHas('user', function ($q) use ($identifier) {
            $q->where('ssn', $identifier)
                ->orWhere('phone_number', $identifier);
        });
    }
}
