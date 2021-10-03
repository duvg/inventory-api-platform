<?php

namespace App\Api\Action\User;

use App\Entity\User;
use App\Service\User\ActivateAccountService;
use Symfony\Component\HttpFoundation\Request;

class ActivateAccount
{
    private ActivateAccountService $accountService;

    public function __construct(ActivateAccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function __invoke(Request $request, string $id): User
    {
        return $this->accountService->activate($request, $id);
    }
}