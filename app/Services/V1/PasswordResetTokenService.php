<?php

namespace App\Services\V1;

use App\Models\PasswordResetToken;

interface PasswordResetTokenService
{
    function createUniqueToken(string $email): PasswordResetToken;

    function resetPassword(string $token, string $password): void;
}
