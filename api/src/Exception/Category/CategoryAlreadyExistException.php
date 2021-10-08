<?php

namespace App\Exception\Category;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class CategoryAlreadyExistException extends ConflictHttpException
{
    public static function fromName(string $name): self
    {
        throw new self(sprintf('Category with name %s already exist', $name));
    }
}