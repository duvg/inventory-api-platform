<?php

declare(strict_types=1);

namespace App\Entity;

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


}