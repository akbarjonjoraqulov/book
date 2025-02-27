<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class AboutMeAction extends AbstractController
{
    public function __invoke(#[CurrentUser] User $user, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->serialize($user, 'json', ['groups' => ['user:read']]);
        return new JsonResponse($data, 200, [], true);
    }
}
