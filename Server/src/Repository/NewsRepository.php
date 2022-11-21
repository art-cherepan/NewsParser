<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function save(News $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @return News[]
     */
    public function findByStartIdAndCount($id, $count): array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.id > :id')
            ->setParameter('id', $id)
            ->setMaxResults($count)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return News[]
     */
    public function findFirstByCount($count): array
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.id', 'ASC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findRatingForAll()
    {
        return $this->createQueryBuilder('n')
            ->select('n.id, n.rating')
            ->getQuery()
            ->getResult()
            ;
    }
}
