<?php

namespace App\Exception\CategoryMovement;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CannotCreateCategoryMovementForAnotherUserException extends AccessDeniedHttpException
{
    public function __construct()
    {
        parent::__construct('You can not create category movements for another user');
    }
}