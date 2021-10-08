<?php

namespace App\Repository;

use App\Entity\Category;
use App\Exception\Category\CategoryNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class CategoryRepository extends BaseRepository
{

    protected static function entityClass(): string
    {
        return Category::class;
    }

    public function findOneByIdOrFail(string $id): Category
    {
        if(null === $category = $this->objectRepository->findOneBy(['id' => $id])) {
            throw CategoryNotFoundException::fromId($id);
        }

        return $category;
    }
    /**
     * @param Category $category
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Category $category): void
    {
        $this->saveEntity($category);
    }

    /**
     * @param Category $category
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Category $category): void
    {
        $this->removeEntity($category);
    }
}