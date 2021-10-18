<?php

declare(strict_types=1);

namespace App\Exception\Movement;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CannotCreateMovementForAnotherUserException extends AccessDeniedHttpException
{
    public function __construct()
    {
        parent::__construct('You can not create movement for another user');
    }
}