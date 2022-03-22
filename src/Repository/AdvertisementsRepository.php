<?php

namespace App\Repository;

use App\Entity\Advertisements;
use App\Form\Model\AdvertisementFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Advertisements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advertisements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advertisements[]    findAll()
 * @method Advertisements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertisementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advertisements::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Advertisements $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Advertisements $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return Advertisements[] Returns an array of Advertisements objects
    */
    
    public function findNews()
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a')
            ->orderBy('a.creation_date', 'DESC')
            ->setMaxResults(5)
            ->leftJoin('a.advertisement_dogs', 'd')
            ->where('d.isAdopted = :isAdopted')
            ->setParameter('isAdopted', false)
            ->getQuery()
            ->getResult();
    }
    
    public function findByFilter(AdvertisementFilter $filter)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('DISTINCT a')
            ->orderBy('a.creation_date', 'DESC')
            ->leftJoin('a.advertisement_dogs', 'd')
            ->leftJoin('d.dog_species','s')
            ->where('d.isAdopted = :isAdopted')
            ->setParameter('isAdopted', false);
            if($filter->getIsLof()){
                $qb
                    ->andWhere('d.isLOF = :isLof')
                    ->setParameter('isLof', true)
                ;
            }
            if($filter->getAcceptOtherAnimals()){
                $qb
                    ->andWhere('d.otherAnimals = :acceptOtherAnimals')
                    ->setParameter('acceptOtherAnimals', true)
                ;
            }
            if($filter->getSpecies())
            {
                $qb
                    ->andWhere('s.id = :specie')
                    ->setParameter('specie', $filter->getSpecies())
                ;
            }
            if($filter->getDate())
            {
                $qb
                    ->andWhere('a.creation_date >= :date')
                    ->setParameter('date', $filter->getDate());
            }
            return $qb
                ->getQuery()
                ->getResult()
            ;
    }

    // /**
    //  * @return Advertisements[] Returns an array of Advertisements objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Advertisements
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
