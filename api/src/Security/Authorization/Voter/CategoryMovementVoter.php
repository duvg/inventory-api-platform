<?php

namespace App\Security\Authorization\Voter;

use App\Entity\CategoryMovement;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CategoryMovementVoter extends Voter
{

    public const CATEGORYMOVEMENT_READ = 'CATEGORYMOVEMENT_READ';
    public const CATEGORYMOVEMENT_UPDATE = 'CATEGORYMOVEMENT_UPDATE';
    public const CATEGORYMOVEMENT_DELETE = 'CATEGORYMOVEMENT_DELETE';
    public const CATEGORYMOVEMENT_CREATE = 'CATEGORYMOVEMENT_CREATE';


    protected function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, $this->supportedAttributes(), true);
    }

    /**
     * @param CategoryMovement|null $subject
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $tokenUser */
        $tokenUser = $token->getUser();

        if (self::CATEGORYMOVEMENT_CREATE === $attribute) {
            return true;
        }

        if (null !== $group = $subject->getGroup()) {
            if (\in_array($attribute, [self::CATEGORYMOVEMENT_READ, self::CATEGORYMOVEMENT_UPDATE, self::CATEGORYMOVEMENT_DELETE])) {
                return $tokenUser->isMemberOfGroup($group);
            }
        }

        if (\in_array($attribute, [self::CATEGORYMOVEMENT_READ, self::CATEGORYMOVEMENT_UPDATE, self::CATEGORYMOVEMENT_DELETE])) {
            return $subject->isOwnedBy($tokenUser);
        }

        return false;
    }

    private function supportedAttributes(): array
    {
        return [
            self::CATEGORYMOVEMENT_READ,
            self::CATEGORYMOVEMENT_CREATE,
            self::CATEGORYMOVEMENT_UPDATE,
            self::CATEGORYMOVEMENT_DELETE,
        ];
    }
}