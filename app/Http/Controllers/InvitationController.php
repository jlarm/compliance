<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\InvitationResource;
use App\Models\Invitation;
use Inertia\Inertia;
use Inertia\Response;

final class InvitationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('central/user/OpenInvites', [
            'invitations' => InvitationResource::collection(
                Invitation::query()
                    ->orderBy('email')
                    ->paginate(10)
            )->resolve(),
        ]);
    }
}
