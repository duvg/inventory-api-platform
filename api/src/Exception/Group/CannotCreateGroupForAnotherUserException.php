<?php

declare(strict_types=1);

namespace App\Exception\Group;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CannotCreateGroupForAnotherUserException extends AccessDeniedHttpException
{
    public function __construct()
    {
        parent::__construct('You cannot create groups for another user');
    }
}