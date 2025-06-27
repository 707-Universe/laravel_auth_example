<?php

namespace App\Services\V1;

use App\Http\Requests\V1\User\CreateRequest;
use App\Jobs\V1\User\SendEmailActivationMail;
use App\Models\EmailActivationToken;
use App\Models\PasswordResetToken;
use App\Models\User;

class UserServiceImpl implements UserService
{
    private EmailActivationTokenService $emailActivationTokenService;

    public function __construct(EmailActivationTokenService $emailActivationTokenService)
    {
        $this->emailActivationTokenService = $emailActivationTokenService;
    }

    public function createFromRequest(CreateRequest $request): User
    {
        // 未アクティベートのユーザーが存在する場合は削除する
        $this->deleteNotActivatedUser($request->email);

        // ユーザーを保存する
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        // アクティベーショントークンを発行する
        $emailActivationToken = $this->emailActivationTokenService->createUniqueToken($user->email);

        // アクティベーションのためのメールを送信する
        $this->sendEmailActivationMail($user, $emailActivationToken);

        // ユーザーを返す
        return $user;
    }

    private function deleteNotActivatedUser ($email) {
        $userQuery = User::query();
        $userQuery->where('email', $email);
        $userQuery->where('email_verified_at', null);

        if($userQuery->exists()) {
            $emailActivationTokenQuery = EmailActivationToken::query();
            $emailActivationTokenQuery->where('email', $email);
            $emailActivationTokenQuery->delete();

            $passwordResetTokenQuery = PasswordResetToken::query();
            $passwordResetTokenQuery->where('email', $email);
            $passwordResetTokenQuery->delete();
        }

        $userQuery->delete();
    }

    private function sendEmailActivationMail(User $user, EmailActivationToken $emailActivationToken): void
    {
        SendEmailActivationMail::dispatch($user->toArray(), $emailActivationToken->toArray());
    }
}
