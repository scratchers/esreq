<?php

namespace App\Policies;

use App\User;
use App\Esrequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class EsrequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the esrequest.
     *
     * @param  \App\User  $user
     * @param  \App\Esrequest  $esrequest
     * @return mixed
     */
    public function view(User $user, Esrequest $esrequest)
    {
        if ( $this->report($user) ) {
            return true;
        }

        return $user->id == $esrequest->user_id;
    }

    /**
     * Determine whether the user can create esrequests.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the esrequest.
     *
     * @param  \App\User  $user
     * @param  \App\Esrequest  $esrequest
     * @return mixed
     */
    public function update(User $user, Esrequest $esrequest)
    {
        return $user->id == $esrequest->user_id;
    }

    /**
     * Determine whether the user can delete the esrequest.
     *
     * @param  \App\User  $user
     * @param  \App\Esrequest  $esrequest
     * @return mixed
     */
    public function delete(User $user, Esrequest $esrequest)
    {
        return $user->id == $esrequest->user_id;
    }

    /**
     * Restricts all users from admin functions.
     * Admins should be globally authorized in AuthServiceProvider::boot
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function administer(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can run reports on esrequests.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function report(User $user)
    {
        $reports = env('SHIBBOLETH_REPORTS');

        if ( empty($reports) ) {
            return false;
        }

        return $user->entitlements->contains('name', $reports);
    }
}
