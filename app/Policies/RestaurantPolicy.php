<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user)
    {
        return true;
    }

    public function view(?User $user, Restaurant $restaurant)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Restaurant $restaurant)
    {
        return $user->id === $restaurant->user_id || $user->isAdmin();
    }

    public function delete(User $user, Restaurant $restaurant)
    {
        return $user->id === $restaurant->user_id || $user->isAdmin();
    }

    public function restore(User $user, Restaurant $restaurant)
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Restaurant $restaurant)
    {
        return $user->isAdmin();
    }
}
