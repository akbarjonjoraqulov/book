<?php

declare(strict_types=1);

namespace App\Component\User;

use App\Entity\User;
use DateTimeZone;
use Symfony\Component\Clock\DatePoint;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHashed)
    {
    }

    public function create(string $email, string $password, int $age, string $phone, string $gender): User
    {
        $user = new User();

        $passwordHashed = $this->passwordHashed->hashPassword($user, $password);

        $user->setEmail($email);
        $user->setPassword($passwordHashed);
        $user->setAge($age);
        $user->setPhone($phone);
        $user->setGender($gender);
        $user->setCreatedAt(new DatePoint(timezone: new DateTimeZone("Asia/Tashkent")));

        return $user;
    }
}
