<?php

namespace App\Repository;

use App\Entity\MoviesCharacters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MoviesCharacters>
 *
 * @method MoviesCharacters|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoviesCharacters|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoviesCharacters[]    findAll()
 * @method MoviesCharacters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoviesCharactersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoviesCharacters::class);
    }

//    /**
//     * @return MoviesCharacters[] Returns an array of MoviesCharacters objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MoviesCharacters
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
