<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Uid\Uuid;

class Movement
{
    private string $id;
    private CategoryMovement $categoryMovement;
    private User $owner;
    private ?Group $group;
    private float $amount;
    private ?string $filePath;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct(CategoryMovement $categoryMovement, User $owner, float $amount, Group $group = null)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->categoryMovement = $categoryMovement;
        $this->owner = $owner;
        $this->amount = $amount;
        $this->group = $group;
        $this->filePath = null;
        $this->createdAt = new \DateTime();
        $this->markAsUpdated();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return CategoryMovement
     */
    public function getCategoryMovement(): CategoryMovement
    {
        return $this->categoryMovement;
    }

    /**
     * @param CategoryMovement $categoryMovement
     */
    public function setCategoryMovement(CategoryMovement $categoryMovement): void
    {
        $this->categoryMovement = $categoryMovement;
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @return Group|null
     */
    public function getGroup(): ?Group
    {
        return $this->group;
    }


    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    /**
     * @param string|null $filePath
     */
    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function markAsUpdated(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->owner->getId() === $user->getId();
    }

    public function belongsToGroup(Group $group)
    {
        if (null !== $groupD = $this->group) {
            return $groupD->getId() === $group->getId();
        }

        return false;
    }
}