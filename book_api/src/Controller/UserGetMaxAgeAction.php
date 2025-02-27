<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\User\MaxAgeDto;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserGetMaxAgeAction extends AbstractController
{
    public function __invoke(UserRepository $userRepository): JsonResponse
    {
        $dto = new MaxAgeDto($userRepository->findMaxAge());

        return new JsonResponse($dto);
    }
}
