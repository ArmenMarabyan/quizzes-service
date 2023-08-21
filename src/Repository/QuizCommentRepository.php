<?php

namespace App\Repository;

use App\Entity\Quiz;
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

    private const PAGINATOR_PER_PAGE = 100;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizComment::class);
    }

    /**
     * @return QuizComment[] Returns an array of QuizComment objects
     */
    public function getComments(Quiz $quiz): array
    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;


        $query = $this->createQueryBuilder('q')
            ->andWhere('q.quiz = :quiz')
            ->andWhere('q.state = :state')
            ->setParameter('quiz', $quiz)
            ->setParameter('state', 'published')
            ->orderBy('q.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
//            ->setMaxResults(self::PAGINATOR_PER_PAGE)
//            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();

        return $query;
    }

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
