<?php

namespace App\Exception\CategoryMovement;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CannotCreateCategoryMovementForAnotherGroupException extends AccessDeniedHttpException
{
    public function __construct()
    {
        parent::__construct('You can not create category movements for another group');
    }
}