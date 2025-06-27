<?php

namespace App\Exceptions\V1\User\EmailActivationToken;

use Exception;

class NotExistsTokenException extends Exception
{
    public function getError(): string
    {
        return 'トークンが見つかりませんでした。';
    }
}
