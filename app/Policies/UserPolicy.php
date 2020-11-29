<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $otherUser
     * @return mixed
     */
    public function update(User $user, User $otherUser)
    {
        return $user->is_admin && ($user->is($otherUser) || !$otherUser->is_admin);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $otherUser
     * @return mixed
     */
    public function delete(User $user, User $otherUser)
    {
        return $user->is_admin && (!$user->is($otherUser) || !$otherUser->is_admin);
    }
}
