<?php

namespace App\Repository;

use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Activity>
 *
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    /**
     * @return Activity[] Returns an array of Activity objects
     */
    public function findByCity($city): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.city', 'c')
            ->andWhere('c.name LIKE :city')
            ->setParameter('city', "%$city%")
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Activity[] Returns an array of Activity objects
     */
    public function findByCityAndType($city, $type): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.city', 'c')
            ->join('a.type', 't')
            ->andWhere('t.id = :type')
            ->andWhere('c.name LIKE :city')
            ->setParameter('city', "%$city%")
            ->setParameter('type', $type)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }




//    public function findOneBySomeField($value): ?Activity
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
