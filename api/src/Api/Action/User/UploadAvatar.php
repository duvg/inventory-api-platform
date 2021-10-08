<?php

declare(strict_types=1);

namespace App\Api\Action\User;

use App\Entity\User;
use App\Service\Request\RequestService;
use App\Service\User\UploadAvatarService;
use Symfony\Component\HttpFoundation\Request;

class UploadAvatar
{
    private UploadAvatarService $uploadAvatarService;

    public function __construct(UploadAvatarService $uploadAvatarService)
    {
        $this->uploadAvatarService = $uploadAvatarService;
    }

    /**
     * @param Request $request
     * @param $id
     * @return string
     */
    public function __invoke(Request $request, $id): User
    {
        return $this->uploadAvatarService->upload(
            $id,
            RequestService::getField($request, 'avatar')
        );
    }
}
