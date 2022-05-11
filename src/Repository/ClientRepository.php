<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }
    /**
     * @return Client[] Returns an array of Client objects
     */
    public function  findAllByUser($user)
    {
        return $this->createQueryBuilder('c')
            ->where('c.user = :user')
            ->setParameter('user', $user)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function getClientToSelect($key): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.nomClient LIKE :key')
            ->setParameter('key', '%' . $key . '%')
            ->getQuery()
            ->getResult();
    }
    public function getClients($key): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.nomClient = :key')
            ->setParameter('key', '%' . $key . '%')
            ->getQuery()
            ->getResult();
    }
    public function getTotalClients()
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}