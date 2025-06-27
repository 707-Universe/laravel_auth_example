<?php

namespace App\Services\V1;

use App\Models\EmailActivationToken;

interface EmailActivationTokenService
{
    function createUniqueToken(string $email): EmailActivationToken;

    function activate(string $token): void;
}
