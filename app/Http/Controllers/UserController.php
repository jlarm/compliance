<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateNewInvitation;
use App\Http\Requests\CreateUserInvitationFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class UserController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('central/user/Index', [
            'allUsers' => UserResource::collection(
                User::query()
                    ->centralUsers()
                    ->latest()
                    ->get()
            ),
        ]);
    }

    public function store(CreateUserInvitationFormRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        resolve(CreateNewInvitation::class)->handle($attributes);

        return back()->with('success', 'Invitation sent successfully');
    }
}
