<?php

namespace App\Api\Action\Category;

use App\Entity\Category;
use App\Service\Category\CategoryDeleteService;
use Symfony\Component\HttpFoundation\Request;

class Delete
{
    private CategoryDeleteService $categoryDeleteService;

    public function __construct(CategoryDeleteService $categoryDeleteService)
    {
        $this->categoryDeleteService = $categoryDeleteService;
    }

    /**
     * @param string $id
     * @return Category
     */
    public function __invoke(string $id): Category
    {
        return $this->categoryDeleteService->delete($id);
    }
}