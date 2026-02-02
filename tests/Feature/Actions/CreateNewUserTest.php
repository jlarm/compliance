<?php

declare(strict_types=1);

use App\Actions\Fortify\CreateNewUser;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

test('creates a new user', function (): void {
    $action = new CreateNewUser();

    $user = $action->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => Role::ADMIN->value,
        'qualified_individual' => true,
    ]);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->name)->toBe('Test User')
        ->and($user->email)->toBe('test@example.com')
        ->and($user->role)->toBe(Role::ADMIN)
        ->and($user->qualified_individual)->toBeTrue();
});

test('validates required fields', function (): void {
    $action = new CreateNewUser();

    $action->create([]);
})->throws(ValidationException::class);

test('validates email is unique', function (): void {
    User::factory()->create(['email' => 'existing@example.com']);

    $action = new CreateNewUser();

    $action->create([
        'name' => 'Test User',
        'email' => 'existing@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => Role::ADMIN->value,
        'qualified_individual' => true,
    ]);
})->throws(ValidationException::class);

test('validates role is valid', function (): void {
    $action = new CreateNewUser();

    $action->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'invalid-role',
        'qualified_individual' => true,
    ]);
})->throws(ValidationException::class);
