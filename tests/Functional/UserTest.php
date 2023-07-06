<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\USer;
use App\Kernel;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class UserTest extends ApiTestCase
{
    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    use RefreshDatabaseTrait;


}
