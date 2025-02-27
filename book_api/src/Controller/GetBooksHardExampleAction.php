<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class GetBooksHardExampleAction extends AbstractController
{
    public function __invoke(#[CurrentUser] User $user, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->serialize($user, 'json');
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
