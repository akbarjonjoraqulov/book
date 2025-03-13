<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetBooksByCategoryAction extends AbstractController
{
    public function __invoke(Request $request, BookRepository $bookRepository): JsonResponse
    {
        $categoryId = $request->query->get('categoryId');
        $page = $request->query->get('page', 1);

        if (!$categoryId) {
            throw new BadRequestHttpException("Invalid category id");
        }

        $offset = ($page - 1) * 10;

        $books = $bookRepository->findBy(
            ['category' => (int)$categoryId],
            [],
            10,
            $offset
        );

        if (empty($books)) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        return $this->json($books);
    }
}
