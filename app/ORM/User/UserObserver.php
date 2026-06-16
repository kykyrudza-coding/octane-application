<?php

declare(strict_types=1);

namespace App\ORM\User;

final class UserObserver
{
    public function creating(User $user): void
    {
        // model change
    }

    public function created(User $user): void
    {
        // send email
    }

    public function updating(User $user): void
    {
        // model change
    }

    public function updated(User $user): void
    {
        // notify user
    }

    public function deleting(User $user): void
    {
        // model change
    }

    public function deleted(User $user): void
    {
        // send email
    }
}