<?php

namespace App\Repository;

use App\Entity\QuizComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuizComment>
 *
 * @method QuizComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizComment[]    findAll()
 * @method QuizComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizComment::class);
    }

//    /**
//     * @return QuizComment[] Returns an array of QuizComment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?QuizComment
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
