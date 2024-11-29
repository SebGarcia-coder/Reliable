<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    //    /**
    //     * @return Question[] Returns an array of Question objects
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

    //    public function findOneBySomeField($value): ?Question
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findOne(int $id): ?Question
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneRandomQuestionByType(string $type, ?array $usedQuestionIds = null): ?Question
    {
        $queryBuilder = $this->createQueryBuilder('q')
        ->andWhere('q.type = :type')
        ->setParameter('type', $type);

    // Add the NOT IN condition only if $usedIds is not empty
    if (!empty($usedQuestionIds)) {
        $queryBuilder->andWhere('q.id NOT IN (:usedQuestionIds)')
                     ->setParameter('usedQuestionIds', $usedQuestionIds);
    }

    return $queryBuilder
        ->orderBy('RAND()')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
    }

}
