<?php

namespace App\Exceptions\V1\User\EmailActivationToken;

use Exception;

class UserNotFoundException extends Exception
{
    public function getError(): string
    {
        return 'ユーザーが見つかりませんでした。';
    }
}
