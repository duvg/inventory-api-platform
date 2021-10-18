<?php

declare(strict_types=1);

namespace App\Service\Movement;

use App\Entity\Movement;
use App\Entity\User;
use App\Exception\Movement\MovementDoesNotBelongsToGroupException;
use App\Exception\Movement\MovementDoesNotBelongsToUserException;
use App\Repository\MovementRepository;
use App\Service\File\FileService;
use League\Flysystem\Visibility;
use Symfony\Component\HttpFoundation\Request;

class UploadFileService
{
    private FileService $fileService;
    private MovementRepository $movementRepository;

    public function __construct(FileService $fileService, MovementRepository $movementRepository)
    {
        $this->fileService = $fileService;
        $this->movementRepository = $movementRepository;
    }

    public function uploadFile(Request  $request, User $user, string $id): Movement
    {
        $movement = $this->movementRepository->findOneByIdOrFail($id);


        if (null !== $group = $movement->getGroup()) {
            if (!$user->isMemberOfGroup($group)) {
                throw new MovementDoesNotBelongsToGroupException();
            }
        }

        if (!$movement->isOwnedBy($user)) {
            throw new MovementDoesNotBelongsToUserException();
        }

        $file = $this->fileService->validateFile($request, FileService::MOVEMENT_INPUT_NAME);

        $this->fileService->deleteFile($movement->getFilePath());

        $fileName = $this->fileService->uploadFile(
            $file,
            FileService::MOVEMENT_INPUT_NAME,
            Visibility::PRIVATE
        );

        $movement->setFilePath($fileName);

        $this->movementRepository->save($movement);

        return $movement;
    }
}