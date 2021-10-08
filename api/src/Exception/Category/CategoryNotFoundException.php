<?php

declare(strict_types=1);

namespace App\Exception\Category;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryNotFoundException extends NotFoundHttpException
{
    public static function fromId(string $id): self
    {
        throw new self(sprintf('Category with id: %s not found', $id));
    }
}