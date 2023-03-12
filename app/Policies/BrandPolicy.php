<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BrandPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Brand $brand)
    {
        switch ($user->role) {
            case 'Admin':
                return true;
            case 'user':
                return $brand;
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Brand $brand)
    {
        switch ($user->role) {
            case 'Admin':
                return true;
            case 'user':
                return $brand->company_id === $user->company_id;
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Brand $brand)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Brand $brand)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Brand $brand)
    {
        //
    }
}
