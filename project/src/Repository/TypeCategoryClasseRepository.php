<?php

namespace App\Repository;

use App\Entity\TypeCategoryClasse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeCategoryClasse>
 *
 * @method TypeCategoryClasse|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeCategoryClasse|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeCategoryClasse[]    findAll()
 * @method TypeCategoryClasse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeCategoryClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeCategoryClasse::class);
    }

    public function save(TypeCategoryClasse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeCategoryClasse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TypeCategoryClasse[] Returns an array of TypeCategoryClasse objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeCategoryClasse
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
