<?php

namespace App\Services\V1;

use App\Http\Requests\V1\User\CreateRequest;
use App\Jobs\V1\User\SendEmailActivationMail;
use App\Models\User;

class UserServiceImpl implements UserService
{
    public function createFromRequest(CreateRequest $request): User
    {
        // Todo: 入力と一致するメールアドレスが未アクティベートの場合は削除する
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        $this->sendEmailActivationMail($user);

        return $user;
    }

    private function sendEmailActivationMail(User $user): void
    {
        SendEmailActivationMail::dispatch($user);
    }
}
