<?php

namespace App\Service\Category;

use App\Entity\Category;
use App\Exception\Category\CategoryNotFoundException;
use App\Repository\CategoryRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class CategoryDeleteService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $categoryId
     * @return Category
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete($categoryId): Category
    {
        if(null === $category = $this->categoryRepository->findOneByIdOrFail($categoryId))
        {
            throw CategoryNotFoundException::fromId($categoryId);
        }

        $category->setActive(false);

        $this->categoryRepository->save($category);

        return $category;
    }
}