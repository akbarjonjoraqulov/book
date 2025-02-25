<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\User\UserFactory;
use App\Component\User\UserManager;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class UserCreateAction extends AbstractController
{
    private readonly UserFactory $userFactory;
    private readonly UserManager $userManager;
    private readonly SerializerInterface $serializer;

    public function __construct(UserFactory $userFactory, UserManager $userManager, SerializerInterface $serializer)
    {
        $this->userFactory = $userFactory;
        $this->userManager = $userManager;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->getContent();
        $user = $this->serializer->deserialize($data, User::class, 'json');

        $user = $this->userFactory->create(
            $user->getEmail(),
            $user->getPassword(),
            $user->getAge(),
            $user->getPhone(),
            $user->getGender()
        );

        $this->userManager->save($user, true);

        return new JsonResponse($this->serializer->serialize($user, 'json'), 201, [], true);
    }
}
