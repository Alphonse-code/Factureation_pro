<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    /**
     * @return Facture[] Returns an array of Facture objects
     */

    public function findAllByUser($user)
    {
        return $this->createQueryBuilder('f')
            ->where('f.user = :user')
            ->setParameter('user', $user)
            ->join('f.ligneFacture', 'l')
            ->leftJoin('f.clent', 'c')
            ->addselect('c.nomClient as nomClient')
            ->addselect('l.totalTTC as totalTTC')
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Facture[] Returns an array of Facture objects
     */
    public function recentFacture($user)
    {
        return $this->createQueryBuilder('f')
            ->where('f.user = :user')
            ->setParameter('user', $user)
            ->orderBy('f.id', 'DESC')
            ->getQuery()
            ->setMaxResults(5)
            ->getResult();
    }
    /**
     * @return Facture[] Returns an array of Client objects
     */

    public function findInvoiceByUser($ref, $user): array
    {
        return $this->createQueryBuilder('f')
            ->select('f', 'l', 'c')
            ->join('f.clent', 'c')
            ->leftjoin('f.ligneFacture', 'l')
            ->addselect('c.nomClient as nomClient')
            ->addselect('SUM(l.totalTTC) as totalTTC')
            ->where('f.ref LIKE :key')
            ->setParameter('key', '%' . $ref . '%')
            ->andWhere('f.user =:user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
    /**
     * @return Facture[] Returns an array of Client objects
     */

    public function filterDate($date, $date1, $user): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.date BETWEEN :start and :end')
            ->setParameter('start', $date)
            ->setParameter('end', $date1)
            ->join('f.ligneFacture', 'l')
            ->leftJoin('f.clent', 'c')
            ->addselect('c.nomClient as nomClient')
            ->addselect('l.totalTTC as totalTTC')
            ->andWhere('f.user =:user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
    /**
     * @return Facture[] Returns an array of Client objects
     */

    public function filterEtat($etat, $user): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.etat = :key')
            ->setParameter('key', $etat)
            ->join('f.ligneFacture', 'l')
            ->leftJoin('f.clent', 'c')
            ->addselect('c.nomClient as nomClient')
            ->addselect('l.totalTTC as totalTTC')
            ->andWhere('f.user =:user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
    public function getTotalFacture($user)
    {
        return $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getTotalFactureBruillon($user)
    {
        return $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.user = :user')
            ->setParameter('user', $user)
            ->andWhere('f.etat =:etat')
            ->setParameter('etat', 0)
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function getTotalFactureEnvoyer($user)
    {
        return $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.user = :user')
            ->setParameter('user', $user)
            ->andWhere('f.etat =:etat')
            ->setParameter('etat', 1)
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function getTotalFacturePaye($user)
    {
        return $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.user = :user')
            ->setParameter('user', $user)
            ->andWhere('f.etat =:etat')
            ->setParameter('etat', 2)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findFactureByClient($user, $facture)
    {
        return $this->createQueryBuilder('f')
            ->where('f.id =:facture')
            ->setParameter('facture', $facture)
            ->andWhere('f.user =:user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
    public function getFactureClient($id, $user)
    {
        return $this->createQueryBuilder('f')
            ->where('f.clent =:client')
            ->setParameter('client', $id)
            ->andWhere('f.user =:user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
    public function getInvoiceData($sav)
    {
        return $this->createQueryBuilder('r')
            ->select('r', 'p')
            ->join('r.pieces', 'p')
            ->addselect('SUM(p.sousTotal) as total')
            ->where('r.id = :sav')
            ->setParameter('sav', $sav)
            ->getQuery()
            ->getResult();
    }
    public function getDataInvoice($id, $user)
    {
        return $this->createQueryBuilder('f')
            ->where('f.user = :user')
            ->setParameter('user', $user)
            ->andWhere('f.id=:ref')
            ->setParameter('ref', $id)
            ->getQuery()
            ->getSingleResult();
    }
    /*
    public function findOneBySomeField($value): ?Facture
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}