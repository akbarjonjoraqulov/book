<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FullNameDtoAction extends AbstractController
{
    public function __invoke(Request $request): JsonResponse
    {
        $fullNameDto = json_decode($request->getContent(), true);

        return $this->json($fullNameDto);
    }
}
