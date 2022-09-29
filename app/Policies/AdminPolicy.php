<?php

namespace App\Policies;

use App\Models\Member;
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

    public function editMember(User $user, Member $Member): bool
    {
        $user = User::find(Auth::id());

        if ($user->role_id === 1) {
            return true;
        }

        return $Member->user_id === $user->id;
    }
}
