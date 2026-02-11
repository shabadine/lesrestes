<?php

namespace App\Repository;

use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

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
     * Gère singulier/pluriel, minuscules/majuscules.
     */
    public function findByNameLike(string $search): array
    {
        return $this->createQueryBuilder('i')
            ->where('LOWER(i.nom) LIKE LOWER(:search)')
            ->setParameter('search', '%'.$search.'%')
            ->getQuery()
            ->getResult();
    }

    public function createAdminSearchQueryBuilder(?string $search): QueryBuilder
    {
        $qb = $this->createQueryBuilder('i')
            ->orderBy('i.nom', 'ASC');

        if ($search) {
            $qb->andWhere('LOWER(i.nom) LIKE LOWER(:search)')
               ->setParameter('search', '%'.strtolower($search).'%');
        }

        return $qb;
    }

    /**
     * Liste paginable de tous les ingrédients (pour la colonne de gauche).
     */
    public function createAllOrderedByNameQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.nom', 'ASC');
    }

    /**
     * Recherche d’ingrédients par plusieurs termes (OR) saisis dans q.
     *
     * @param string[] $terms
     *
     * @return Ingredient[]
     */
    public function searchByNames(array $terms): array
    {
        if (!$terms) {
            return [];
        }

        $qb = $this->createQueryBuilder('i');
        $orConditions = $qb->expr()->orX();

        foreach ($terms as $index => $term) {
            $paramName = "term_$index";
            $orConditions->add("i.nom LIKE :$paramName");
            $qb->setParameter($paramName, '%'.$term.'%');
        }

        return $qb
            ->where($orConditions)
            ->orderBy('i.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère des ingrédients par IDs, triés par nom.
     *
     * @param int[] $ids
     *
     * @return Ingredient[]
     */
    public function findByIdsOrdered(array $ids): array
    {
        if (!$ids) {
            return [];
        }

        return $this->createQueryBuilder('i')
            ->where('i.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->orderBy('i.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
