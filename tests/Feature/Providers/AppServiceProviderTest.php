<?php

declare(strict_types=1);

use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rules\Password;

it('configures strict password rules in production', function (): void {
    App::detectEnvironment(fn (): string => 'production');

    $password = Password::default();

    expect($password)
        ->toBeInstanceOf(Password::class)
        ->and((fn () => $this->min)->call($password))->toBe(12)
        ->and((fn () => $this->mixedCase)->call($password))->toBeTrue()
        ->and((fn () => $this->letters)->call($password))->toBeTrue()
        ->and((fn () => $this->numbers)->call($password))->toBeTrue()
        ->and((fn () => $this->symbols)->call($password))->toBeTrue()
        ->and((fn () => $this->uncompromised)->call($password))->toBeTrue();
});
