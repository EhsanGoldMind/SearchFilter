<?php

namespace App\Criteria;

class AmountCriteria
{
    public function apply($query, $amount) {
        if (isset($amount['min'])) {
            $query->where('amount', '>=', $amount['min']);
        }
        if (isset($amount['max'])) {
            $query->where('amount', '<=', $amount['max']);
        }
    }
}
