<?php

namespace App\Policies;

use App\Models\Cuisine;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CuisinePolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user)
    {
        return true;
    }

    public function view(?User $user, Cuisine $cuisine)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Cuisine $cuisine)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Cuisine $cuisine)
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Cuisine $cuisine)
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Cuisine $cuisine)
    {
        return $user->isAdmin();
    }
}
