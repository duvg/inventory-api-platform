<?php

namespace App\Api\Action\Category;

use App\Entity\Category;
use App\Service\Category\CategoryUpdateService;
use App\Service\Request\RequestService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class Update
{
    private CategoryUpdateService $categoryUpdateService;

    public function __construct(CategoryUpdateService $categoryUpdateService)
    {
        $this->categoryUpdateService = $categoryUpdateService;
    }

    /**
     * @param Request $request
     * @param string $id
     * @return Category
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(Request $request, string $id): Category
    {
        return $this->categoryUpdateService->update(
            $id,
            RequestService::getField($request, 'name'),
            RequestService::getField($request, 'description')
        );
    }
}