<?php

namespace App\Http\repository;

use App\Http\repository\RepositoryInterface\OrderRepositoryInterface;
use App\Http\Services\NotifyService;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Mail;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(private NotifyService $notifyService)
    {
    }
    public function filter(array $criteria)
    {

        $query = Orders::query();

        foreach ($criteria as $filter => $value) {
            try {
                $criteriaClass = ucfirst($filter) . 'Criteria';
                if (!class_exists("App\\Criteria\\$criteriaClass")) {
                    $this->notifyService->notifyAdmin("این فیلتر پشتیبانی نمی شود: $filter");
                    continue;
                }
                $criteriaObject = app("App\\Criteria\\$criteriaClass");
                $criteriaObject->apply($query, $value);
            } catch (Exception $e) {
                $this->notifyService->notifyAdmin($e->getMessage());
                Log::error($e->getMessage());
            }
        }


        return $query->with('user')->get();
    }

}
