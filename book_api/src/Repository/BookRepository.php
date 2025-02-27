<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return Book[] Returns an array of Book objects
     */
    public function findBooksExample(int $userId): array
    {
        return $this->createQueryBuilder('b')
            ->select(
                'b.id',
                'b.name',
                'bc.name as categoryName',
                'bi.id as imageId',
                'bi.filePath',
                'u.email',
                'u.phone'
            )
            ->leftJoin('b.category', 'bc')
            ->innerJoin('b.image', 'bi')
            ->join(User::class, 'u')
            ->AndWhere('u.id = :val')
            ->setParameter('val', $userId)
            ->orderBy('b.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function findOneBookExample(string $text): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.text like :val')
            ->setParameter('val', '%' . $text . '%')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
