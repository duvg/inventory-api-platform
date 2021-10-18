<?php

declare(strict_types=1);

namespace App\Exception\Movement;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MovementNotFoundException extends NotFoundHttpException
{
    private const MESSAGE = 'Movement with %s %s not found';

    public static function fromId(string $id): self
    {
        throw new self(sprintf(self::MESSAGE, 'id', $id));
    }

    public static function fromFilePath(string $filePath): self
    {
        throw new self(sprintf(self::MESSAGE, 'filePath', $filePath));
    }
}