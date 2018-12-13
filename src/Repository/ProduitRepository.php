<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // récupère les produits en cours de livraison
    public function findProduitsEnCommande()
    {
        return $this->createQueryBuilder('p')
            ->where('p.statut = :en_cours')
            ->setParameter('en_cours', 'en commande')
            ->orderBy('p.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // récupère les produits conformes
    public function findProduitsConformes()
    {
        return $this->createQueryBuilder('p')
            ->where('p.statut = :en_cours')
            ->setParameter('en_cours', 'conforme')
            ->orderBy('p.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // récupère les produits non conformes
    public function findProduitsNonConforme()
    {
        return $this->createQueryBuilder('p')
            ->where('p.statut = :en_cours')
            ->setParameter('en_cours', 'non conforme')
            ->orderBy('p.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
