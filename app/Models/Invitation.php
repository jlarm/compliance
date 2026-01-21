<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Role;
use Carbon\CarbonInterface;
use Database\Factories\InvitationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read string $email
 * @property-read Role $role
 * @property-read string $token
 * @property-read int $invited_by
 * @property-read CarbonInterface|null $expires_at
 * @property-read CarbonInterface|null $accepted_at
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
final class Invitation extends Model
{
    /** @use HasFactory<InvitationFactory> */
    use HasFactory;

    public function isValid(): bool
    {
        return $this->accepted_at === null && ! $this->hasExpired();
    }

    public function hasExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * @return BelongsTo<Invitation, User>
     */
    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'email' => 'string',
            'role' => Role::class,
            'token' => 'string',
            'invited_by' => 'integer',
            'expires_at' => 'datetime',
            'accepted_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
