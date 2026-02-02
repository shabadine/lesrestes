<?php

namespace App\Repository;

use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;


/**
 * @extends ServiceEntityRepository<Ingredient>
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }
    
    /**
     * Recherche des ingrédients par nom (LIKE)
     * Gère singulier/pluriel, minuscules/majuscules
     */
    public function findByNameLike(string $search): array
    {
        return $this->createQueryBuilder('i')
            ->where('LOWER(i.nom) LIKE LOWER(:search)')
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    }

     public function createAdminSearchQueryBuilder(?string $search): QueryBuilder
    {
    $qb = $this->createQueryBuilder('i')
        ->orderBy('i.nom', 'ASC');

    if ($search) {
        $qb->andWhere('LOWER(i.nom) LIKE LOWER(:search)')
           ->setParameter('search', '%' . strtolower($search) . '%');
    }

    return $qb;
    }


}