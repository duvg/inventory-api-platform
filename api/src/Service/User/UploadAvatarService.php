<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Cloudinary\Cloudinary;
use Symfony\Component\HttpFoundation\Request;

class UploadAvatarService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $id
     * @param string $path
     * @return string
     */
    public function upload(string $id, string $path): User
    {
        $user = $this->userRepository->findOneByIdOrFail($id);
        $user->setAvatar($path);
        $this->userRepository->save($user);

        return $user;
    }
}