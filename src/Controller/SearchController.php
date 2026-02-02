<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use App\Repository\RecetteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SearchController extends AbstractController
{
    #[Route('/recherche', name: 'app_search')]
    public function index(
        Request $request,
        IngredientRepository $ingredientRepository,
        RecetteRepository $recetteRepository,
        PaginatorInterface $paginator
    ): Response {
        // 1) Liste paginée de tous les ingrédients
        $ingredients = $paginator->paginate(
            $ingredientRepository->createAllOrderedByNameQueryBuilder(),
            $request->query->getInt('page_ing', 1),
            20
        );

        /** @var Ingredient[] $selectedIngredients */
        $selectedIngredients = [];
        $recettesResults     = [];

        // 2) Ingrédients depuis le champ libre q (ex: "tomate, basilic")
        $query = $request->query->get('q');
        if ($query) {
            $searchTerms = array_filter(
                array_map('trim', explode(',', $query))
            );

            if ($searchTerms) {
                $selectedIngredients = $ingredientRepository->searchByNames($searchTerms);
            }
        }

        // 3) Ingrédients depuis le paramètre ?ingredients=1,2,3
        $ingredientIds = $request->query->get('ingredients');
        if ($ingredientIds) {
            $ids = array_filter(
                array_map('intval', explode(',', $ingredientIds))
            );

            if ($ids) {
                $selectedById = $ingredientRepository->findByIdsOrdered($ids);

                foreach ($selectedById as $ingredient) {
                    if (!in_array($ingredient, $selectedIngredients, true)) {
                        $selectedIngredients[] = $ingredient;
                    }
                }
            }
        }

        // 4) Recherche de recettes à partir des ingrédients sélectionnés
        if ($selectedIngredients) {
            $selectedIds     = array_map(fn (Ingredient $i) => $i->getId(), $selectedIngredients);
            $recettesResults = $recetteRepository->findByIngredients(
                $selectedIds,
                requireAll: true
            );
        }

        $recettes = $paginator->paginate(
            $recettesResults,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('search/recherche.html.twig', [
            'ingredients'         => $ingredients,
            'selectedIngredients' => $selectedIngredients,
            'recettes'            => $recettes,
        ]);
    }
}
