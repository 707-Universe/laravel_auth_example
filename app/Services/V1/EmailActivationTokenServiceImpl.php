<?php

namespace App\Services\V1;

use App\Exceptions\V1\User\EmailActivationToken\NotExistsTokenException;
use App\Exceptions\V1\User\EmailActivationToken\UserNotFoundException;
use App\Jobs\V1\User\SendEmailActivatedMail;
use App\Mail\V1\User\EmailActivatedMail;
use App\Models\EmailActivationToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class EmailActivationTokenServiceImpl implements EmailActivationTokenService
{
    function createUniqueToken(string $email): EmailActivationToken
    {
        $query = EmailActivationToken::query();

        $token =  null;

        while ($token = Str::random(32)) {
            $query->where('token', $token);
            if ($query->exists() === false) {
                break;
            }
        }

        $emailActivationToken = new EmailActivationToken();
        $emailActivationToken->email = $email;
        $emailActivationToken->token = $token;
        $emailActivationToken->save();

        return $emailActivationToken;
    }

    function activate(string $token): void
    {
        $emailActivationTokenQuery = EmailActivationToken::query();
        $emailActivationTokenQuery->where('token', $token);
        $emailActivationTokenQuery->where('created_at', '>=', Carbon::now()->subHours(24));
        $emailActivationToken = $emailActivationTokenQuery->first();

        // Todo: 24時間を過ぎたトークンを削除するジョブを作成する

        if ($emailActivationToken === false) {
            throw new NotExistsTokenException();
        }

        $userQuery = User::query();
        $userQuery->where('email', $emailActivationToken->email);
        $user = $userQuery->first();

        if ($user === false) {
            throw new UserNotFoundException();
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        $emailActivationTokenQuery = EmailActivationToken::query();
        $emailActivationTokenQuery->where('email', $user->email);
        $emailActivationTokenQuery->delete();

        SendEmailActivatedMail::dispatch(new EmailActivatedMail($user));
    }
}
