<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetBooksByCategoryAction extends AbstractController
{
    public function __invoke(Request $request, BookRepository $bookRepository): array
    {
        $categoryId = $request->query->get('categoryId');
        $page = $request->query->get('page');

        if (!$categoryId) {
            throw new BadRequestException("Invalid category id");
        }

        return $bookRepository->findBy(['category' => (int)$categoryId], limit: 10, offset: --$page * 10);
    }
}
