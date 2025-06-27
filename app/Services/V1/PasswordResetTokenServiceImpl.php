<?php

namespace App\Services\V1;

use App\Exceptions\V1\User\EmailActivationToken\UserNotFoundException;
use App\Exceptions\V1\User\PasswordResetToken\NotExistsTokenException;
use App\Jobs\V1\User\SendPasswordChangedMail;
use App\Mail\V1\User\PasswordChangedMail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetTokenServiceImpl implements PasswordResetTokenService
{
    function createUniqueToken(string $email): PasswordResetToken
    {
        $query = PasswordResetToken::query();

        while ($token = Str::random(32)) {
            $query->where('token', $token);
            if ($query->exists() === false) {
                break;
            }
        }

        $passwordResetToken = new PasswordResetToken();
        $passwordResetToken->email = $email;
        $passwordResetToken->token = $token;
        $passwordResetToken->save();

        return $passwordResetToken;
    }

    function resetPassword(string $token, string $password): void
    {
       $passwordResetTokenQuery = PasswordResetToken::query();
       $passwordResetTokenQuery->where('token', $token);
       $passwordResetToken = $passwordResetTokenQuery->first();

       if($passwordResetToken === false) {
           throw new NotExistsTokenException();
       }

       $userQuery = User::query();
       $userQuery->where('email', $passwordResetToken->email);
       $user = $userQuery->first();

       if($user === false) {
           throw new UserNotFoundException();
       }

       $user->password = Hash::make($password);
       $user->save();

        $passwordResetTokenQuery = PasswordResetToken::query();
        $passwordResetTokenQuery->where('email', $user->email);
        $passwordResetTokenQuery->delete();

        SendPasswordChangedMail::dispatch(new PasswordChangedMail($user));
    }
}
