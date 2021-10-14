<?php

namespace App\Exception\Group;

class OwnerCannotBeDeletedException extends \Symfony\Component\HttpKernel\Exception\ConflictHttpException
{
    public function __construct()
    {
        parent::__construct('Owner can not be deleted from a group. Try deleting the group instead');
    }
}