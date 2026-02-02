<?php

namespace App\Repository;

use App\Entity\Favori;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Favori>
 */
class FavoriRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favori::class);
    }

    public function findByUserAndRecette($user, $recette): ?Favori
{
    return $this->findOneBy([
        'user' => $user,
        'recette' => $recette
    ]);
}
    
    //méthode “mes favoris”
     public function createUserFavorisQueryBuilder($user): \Doctrine\ORM\QueryBuilder
{
    return $this->createQueryBuilder('f')
        ->where('f.user = :user')
        ->setParameter('user', $user)
        ->orderBy('f.dateAjout', 'DESC');
}
}
