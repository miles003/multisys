<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendEmailJob;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->password = Hash::make($user->password);
        dispatch(new SendEmailJob($user->email));
    }
}
