<?php

namespace App\Api\Listener\PreWriteListener;

use App\Entity\CategoryMovement;
use App\Entity\User;
use App\Exception\CategoryMovement\CannotCreateCategoryMovementForAnotherGroupException;
use App\Exception\CategoryMovement\CannotCreateCategoryMovementForAnotherUserException;
use App\Exception\CategoryMovement\UnsupportedCategoryMovementTypeException;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CategoryMovementPreWriteListener implements PreWriteListener
{
    private const CATEGORYMOVEMENT_POST = 'api_category_movements_post_collection';

    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelView(ViewEvent $event): void
    {
        /** @var User|null $tokenUser */
        $tokenUser = $this->tokenStorage->getToken()
            ? $this->tokenStorage->getToken()->getUser()
            : null;

        $request = $event->getRequest();

        if (self::CATEGORYMOVEMENT_POST === $request->get('_route')) {

            /** @var CategoryMovement $categoryMovement */
            $categoryMovement = $event->getControllerResult();

            $type = $categoryMovement->getType();
            if (!\in_array($type, [CategoryMovement::EXPENSE, CategoryMovement::INCOME])) {
                throw UnsupportedCategoryMovementTypeException::fromType($type);
            }

            if (null !== $group = $categoryMovement->getGroup()) {
                if (!$tokenUser->isMemberOfGroup($group)) {
                    throw new CannotCreateCategoryMovementForAnotherGroupException();
                }
            }

            if(!$categoryMovement->isOwnedBy($tokenUser)) {
                throw new CannotCreateCategoryMovementForAnotherUserException();
            }
        }

    }
}