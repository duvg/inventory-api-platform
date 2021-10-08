<?php

namespace App\Service\Category;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class CategoryUpdateService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @return Category
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(string $id, string $name, string $description): Category
    {
        $category = $this->categoryRepository->findOneByIdOrFail($id);

        $category->setName($name);
        $category->setDescription($description);

        $this->categoryRepository->save($category);

        return $category;
    }
}