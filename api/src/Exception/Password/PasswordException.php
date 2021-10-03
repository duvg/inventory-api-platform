<?php

namespace App\Exception\Password;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PasswordException extends BadRequestException
{
    public static function invalidLength(): self
    {
        throw new self('Password must be a least 6 characters');
    }

    public static function oldPasswordDoesNotMatch(): self
    {
        throw new self('Old password does not match');
    }
}