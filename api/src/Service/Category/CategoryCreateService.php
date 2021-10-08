<?php

declare(strict_types=1);

namespace App\Service\Category;

use App\Entity\Category;
use App\Exception\Category\CategoryAlreadyExistException;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Exception\ORMException;

class CategoryCreateService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(string $name, string $description = ''): Category
    {
        $category = new Category($name, $description);

        try {
            $this->categoryRepository->save($category);
        } catch(ORMException $exception) {
            throw CategoryAlreadyExistException::fromName($name);
        }

        return $category;
    }
}