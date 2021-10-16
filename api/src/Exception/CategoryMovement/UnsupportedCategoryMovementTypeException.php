<?php

namespace App\Exception\CategoryMovement;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UnsupportedCategoryMovementTypeException extends BadRequestHttpException
{
    private const MESSAGE = 'Unsupported category movement type %s';

    public static function fromType(string $type): self
    {
        throw new self(\sprintf(self::MESSAGE, $type));
    }
}