<?php

namespace App\Tests\Functional\CategoryMovement;

use App\Tests\Functional\TestBase;

class CategoryMovementTestBase extends TestBase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = '/api/v1/category_movements';
    }
}