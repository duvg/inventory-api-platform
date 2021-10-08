<?php

namespace App\Api\Action\Category;

use App\Entity\Category;
use App\Service\Category\CategoryCreateService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;

class Create
{
    private Request $request;
    private CategoryCreateService $categoryCreateService;

    public function __construct(CategoryCreateService $categoryCreateService)
    {
        $this->categoryCreateService = $categoryCreateService;
    }

    public function __invoke(Request $request): Category
    {
        return $this->categoryCreateService->create(
            RequestService::getField($request, 'name'),
            RequestService::getField($request,'description')
        );
    }
}