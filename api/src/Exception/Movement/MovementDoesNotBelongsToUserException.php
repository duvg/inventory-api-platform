<?php

declare(strict_types=1);

namespace App\Exception\Movement;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MovementDoesNotBelongsToUserException extends AccessDeniedHttpException
{
    public function __construct()
    {
        parent::__construct('This movement does not belongs to this user');
    }
}