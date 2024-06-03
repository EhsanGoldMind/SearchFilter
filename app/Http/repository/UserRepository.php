<?php
namespace App\Http\repository;
use App\Models\User;

class UserRepository{
    public function __construct(private User $user)
    {
    }


}
