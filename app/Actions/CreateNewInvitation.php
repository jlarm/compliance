<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\Role;
use App\Jobs\SendInvitationEmailJob;
use App\Models\Invitation;

final class CreateNewInvitation
{
    public function handle(array $attributes): Invitation
    {
        $invitation = Invitation::query()->create([
            'email' => $attributes['email'],
            'role' => Role::CONSULTANT,
        ]);

        dispatch(new SendInvitationEmailJob($invitation));

        return $invitation;
    }
}
