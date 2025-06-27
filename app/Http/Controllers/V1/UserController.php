<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\CreateRequest;
use App\Services\V1\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $service)
    {
    }

    public function create(CreateRequest $request) {
        $this->service->createFromRequest($request);
    }

    public function update() {

    }

    public function delete() {

    }

    public function mine() {

    }

    public function activate_email() {

    }

    public function forgot_password() {

    }

    public function reset_password() {

    }
}
