<?php

namespace App\Policies;

use App\User;
use App\Institution;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstitutionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the institution.
     *
     * @param  \App\User  $user
     * @param  \App\Institution  $institution
     * @return mixed
     */
    public function view(User $user, Institution $institution)
    {
        return true;
    }

    /**
     * Determine whether the user can create institutions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the institution.
     *
     * @param  \App\User  $user
     * @param  \App\Institution  $institution
     * @return mixed
     */
    public function update(User $user, Institution $institution)
    {
        return $user->institution->id == $institution->id;
    }

    /**
     * Determine whether the user can delete the institution.
     *
     * @param  \App\User  $user
     * @param  \App\Institution  $institution
     * @return mixed
     */
    public function delete(User $user, Institution $institution)
    {
        return false;
    }
}
