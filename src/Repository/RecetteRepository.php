<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Recette>
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

    /**
     * @param int[] $ingredientIds
     * @return Recette[]
     */
    public function findByIngredients(array $ingredientIds, bool $requireAll = false): array
    {
        if (empty($ingredientIds)) {
            return [];
        }

        $qb = $this->createQueryBuilder('r')
            ->innerJoin('r.recetteIngredients', 'ri')
            ->innerJoin('ri.ingredient', 'i')
            ->where('i.id IN (:ingredientIds)')
            ->setParameter('ingredientIds', $ingredientIds)
            ->groupBy('r.id');

        if ($requireAll) {
            $qb->having('COUNT(DISTINCT i.id) = :count')
               ->setParameter('count', count($ingredientIds));
        }

        return $qb
            ->orderBy('r.dateCreation', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne un tableau de recettes filtrées.
     *
     * @param array $criteria
     * @param array $orderBy
     * @return Recette[]
     */
    public function findWithFilters(array $criteria = [], array $orderBy = []): array
    {
        return $this->buildFilterQuery($criteria, $orderBy)
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne un QueryBuilder pour pagination.
     */
    public function findWithFiltersQueryBuilder(array $criteria = [], array $orderBy = []): QueryBuilder
    {
        return $this->buildFilterQuery($criteria, $orderBy);
    }

    /**
     *  QueryBuilder pour les filtres.
     */
    private function buildFilterQuery(array $criteria = [], array $orderBy = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('r')
            ->addSelect('c', 'ri', 'i')
            ->leftJoin('r.commentaires', 'c')
            ->leftJoin('r.recetteIngredients', 'ri')
            ->leftJoin('ri.ingredient', 'i')
            ->leftJoin('r.user', 'u')
            ->addSelect('u')
            ->groupBy('r.id');
        if (!empty($criteria['query'])) {
            $qb->andWhere('r.nom LIKE :query OR i.nom LIKE :query')
               ->setParameter('query', '%' . $criteria['query'] . '%');
        }

        if (!empty($criteria['categorie'])) {
            $qb->andWhere('r.categorie = :categorie')
               ->setParameter('categorie', $criteria['categorie']);
        }

        if (!empty($criteria['difficulte'])) {
            $qb->andWhere('r.difficulte = :difficulte')
               ->setParameter('difficulte', $criteria['difficulte']);
        }

        if (!empty($criteria['tempsMax'])) {
            $qb->andWhere('r.tempsCuisson <= :tempsMax')
               ->setParameter('tempsMax', $criteria['tempsMax']);
        }

        foreach ($orderBy as $field => $direction) {
            if ($field === 'moyenneNotes') {
                $qb->addSelect('AVG(c.note) AS HIDDEN avg_note')
                   ->addOrderBy('avg_note', $direction);
            } else {
                $qb->addOrderBy('r.' . $field, $direction);
            }
        }

        return $qb;
    }

    /**
     * Recherche par nom ou par ingrédients.
     *
     * @param string $searchTerm
     * @param int[]  $ingredientIds
     * @return Recette[]
     */
    public function findByNameOrIngredients(string $searchTerm, array $ingredientIds = []): array
    {
        $qb = $this->createQueryBuilder('r')
            ->leftJoin('r.recetteIngredients', 'ri')
            ->leftJoin('ri.ingredient', 'i')
            ->where('r.nom LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%');

        if (!empty($ingredientIds)) {
            $qb->orWhere('i.id IN (:ingredientIds)')
               ->setParameter('ingredientIds', $ingredientIds)
               ->groupBy('r.id')
               ->having('COUNT(DISTINCT i.id) = :count')
               ->setParameter('count', count($ingredientIds));
        }

        return $qb
            ->orderBy('r.dateCreation', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    //Méthode “mes recettes” section profil
    public function createUserRecettesQueryBuilder($user): QueryBuilder
  {
    return $this->createQueryBuilder('r')
        ->where('r.user = :user')
        ->setParameter('user', $user)
        ->orderBy('r.dateCreation', 'DESC');
  }

}
