<?php

namespace App\Policies;

use App\User;
use App\FacultyAccount;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacultyAccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view facultyAccount index.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the facultyAccount.
     *
     * @param  \App\User  $user
     * @param  \App\FacultyAccount  $facultyAccount
     * @return mixed
     */
    public function view(User $user, FacultyAccount $facultyAccount)
    {
        return $user->id == $facultyAccount->user_id;
    }

    /**
     * Determine whether the user can create facultyAccounts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the facultyAccount.
     *
     * @param  \App\User  $user
     * @param  \App\FacultyAccount  $facultyAccount
     * @return mixed
     */
    public function update(User $user, FacultyAccount $facultyAccount)
    {
        //
    }

    /**
     * Determine whether the user can delete the facultyAccount.
     *
     * @param  \App\User  $user
     * @param  \App\FacultyAccount  $facultyAccount
     * @return mixed
     */
    public function delete(User $user, FacultyAccount $facultyAccount)
    {
        //
    }
}
