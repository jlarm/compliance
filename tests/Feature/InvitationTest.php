<?php

declare(strict_types=1);

use App\Enums\Role;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can see page', function (): void {
    $user = User::factory()->create(['role' => Role::ADMIN]);

    $response = $this->actingAs($user)->get('/users');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('central/user/Index')
        ->has('allUsers')
    );
});

test('can invite user', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('invitation.store'), [
        'email' => 'someemail@email.com',
    ]);

    $this->assertDatabaseHas('invitations', [
        'email' => 'someemail@email.com',
        'invited_by' => $user->id,
        'role' => Role::CONSULTANT,
    ]);
});

test('invitation requires email', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('invitation.store'), [
        'email' => '',
    ]);

    $response->assertSessionHasErrors('email');
});

test('invitation email must be valid', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('invitation.store'), [
        'email' => 'notanemail',
    ]);

    $response->assertSessionHasErrors('email');
});

test('can see open invites page', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('invitation.index'));

    $response->assertOk();
});

test('open invites page shows invitations', function (): void {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['invited_by' => $user->id]);

    $response = $this->actingAs($user)->get(route('invitation.index'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('central/user/OpenInvites')
        ->has('invitations', 1)
        ->where('invitations.0.email', $invitation->email)
    );
});
