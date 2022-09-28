<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminPolicy
{
    use HandlesAuthorization;

    public function action(): bool
    {
        $user = User::find(Auth::id());

        return $user->role_id === 1;
    }
}
