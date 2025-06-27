<?php

namespace App\Services\V1;

use App\Http\Requests\V1\User\CreateRequest;
use App\Models\User;

interface UserService
{
    function createFromRequest(CreateRequest $request): User;
}
