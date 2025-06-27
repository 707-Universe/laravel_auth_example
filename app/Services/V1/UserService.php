<?php

namespace App\Services\V1;

use App\Http\Requests\V1\User\CreateRequest;

interface UserService
{
    function createFromRequest(CreateRequest $request);
}
