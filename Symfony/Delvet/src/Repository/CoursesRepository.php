<?php

namespace App\Repository;

use App\Entity\Courses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Courses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Courses|null findOneBy(array $criteria, array $orderBy = null)
 * @method Courses[]    findAll()
 * @method Courses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Courses::class);
    }

    // /**
    //  * @return Courses[] Returns an array of Courses objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Courses
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllByCategoriesId($id)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.categories = :val')
            ->setParameter('val', $id)
            ->orderBy('p.categories') // LIMIT 27, 9// Only 9 products one time
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllWithPagination($page)
    {
        return $this->createQueryBuilder('p')
            ->setFirstResult(($page - 1) * 25) // LIMIT 27, 9
            ->setMaxResults(25) // Only 9 products one time
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLastCreatedAt()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.date_create', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }
}
