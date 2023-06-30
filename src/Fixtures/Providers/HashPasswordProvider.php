<?php

namespace App\Fixtures\Providers;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashPasswordProvider
{
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function hashPassword(string $plainPassword): string
    {
        return $this->hasher->hashPassword(new User(), $plainPassword);
    }

}
