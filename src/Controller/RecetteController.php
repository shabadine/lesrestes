<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Entity\Commentaire;
use App\Form\RecetteType;
use App\Form\CommentaireType;
use App\Form\SearchAdvancedType;
use App\Repository\FavoriRepository;
use App\Repository\IngredientRepository;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/recette')]
final class RecetteController extends AbstractController
{
    #[Route('/recettes', name: 'app_recette_index')]
    public function index(
        Request $request,
        RecetteRepository $recetteRepository,
        PaginatorInterface $paginator
    ): Response {
        $searchForm = $this->createForm(SearchAdvancedType::class);
        $searchForm->handleRequest($request);

        $criteria = [];
        $orderBy  = ['dateCreation' => 'DESC'];

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();

            if (!empty($data['query'])) $criteria['query'] = $data['query'];
            if (!empty($data['categorie'])) $criteria['categorie'] = $data['categorie'];
            if (!empty($data['difficulte'])) $criteria['difficulte'] = $data['difficulte'];
            if (!empty($data['tempsMax'])) $criteria['tempsMax'] = $data['tempsMax'];

            if (!empty($data['tri'])) {
                $orderBy = match ($data['tri']) {
                    'date_asc'   => ['dateCreation' => 'ASC'],
                    'notes_desc' => ['moyenneNotes' => 'DESC'],
                    default      => ['dateCreation' => 'DESC'],
                };
            }
        }

        $queryBuilder = $recetteRepository->findWithFiltersQueryBuilder($criteria, $orderBy);

        $recettes = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('recette/index.html.twig', [
            'recettes'   => $recettes,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    #[Route('/new', name: 'app_recette_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        IngredientRepository $ingredientRepository
    ): Response {
        $recette = new Recette();
        $form    = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recette->setUser($this->getUser());
            $this->hydrateIngredients($recette, $request, $ingredientRepository);
            $entityManager->persist($recette);
            $entityManager->flush();

            $this->addFlash('success', 'Recette créée avec succès !');

            return $this->redirectToRoute('app_recette_show', ['id' => $recette->getId()]);
        }

        return $this->render('recette/new.html.twig', [
            'recette' => $recette,
            'form'    => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recette_show', methods: ['GET', 'POST'])]
    public function show(
        Request $request,
        Recette $recette,
        FavoriRepository $favoriRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $referer = $request->headers->get('referer');
        $session = $request->getSession();
        
        $wasEditingFromProfil = $session->get('edit_origin_profil_' . $recette->getId());
        $fromProfil = ($referer && str_contains($referer, '/profil')) || $wasEditingFromProfil;
        
        if ($wasEditingFromProfil) {
            $session->remove('edit_origin_profil_' . $recette->getId());
        }

        $recette->setVue($recette->getVue() + 1);
        $entityManager->flush();

        $isFavorite = false;
        if ($this->getUser()) {
            $isFavorite = $favoriRepository->findOneBy([
                'user'    => $this->getUser(),
                'recette' => $recette,
            ]) !== null;
        }

        $commentaire = new Commentaire();
        $form        = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setUser($this->getUser());
            $commentaire->setRecette($recette);
            $commentaire->setDateCreation(new \DateTimeImmutable());
            $entityManager->persist($commentaire);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commentaire a été publié !');
            return $this->redirectToRoute('app_recette_show', ['id' => $recette->getId()]);
        }

        return $this->render('recette/show.html.twig', [
            'recette'         => $recette,
            'isFavorite'      => $isFavorite,
            'fromProfil'      => $fromProfil,
            'commentaireForm' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recette_edit', methods: ['GET', 'POST'])]
    #[IsGranted('RECETTE_EDIT', subject: 'recette')] 
    public function edit(
        Request $request,
        Recette $recette,
        EntityManagerInterface $entityManager,
        IngredientRepository $ingredientRepository
    ): Response {
        $referer = $request->headers->get('referer');
        if ($referer && str_contains($referer, '/profil')) {
            $request->getSession()->set('edit_origin_profil_' . $recette->getId(), true);
        }

        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->hydrateIngredients($recette, $request, $ingredientRepository);
            $entityManager->flush();
            $this->addFlash('success', 'Recette modifiée avec succès !');
            return $this->redirectToRoute('app_recette_show', ['id' => $recette->getId()]);
        }

        return $this->render('recette/edit.html.twig', [
            'recette' => $recette,
            'form'    => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_recette_delete', methods: ['POST'])]
    #[IsGranted('RECETTE_DELETE', subject: 'recette')]
    public function delete(
        Request $request,
        Recette $recette,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $recette->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recette);
            $entityManager->flush();
            $this->addFlash('success', 'Recette supprimée avec succès !');
        } else {
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('app_recette_index');
    }

    private function hydrateIngredients(
        Recette $recette,
        Request $request,
        IngredientRepository $ingredientRepository
    ): void {
        $data = $request->request->all('recette')['recetteIngredients'] ?? [];
        foreach ($data as $index => $ingredientData) {
            $ingredientId = $ingredientData['ingredient_id'] ?? null;
            if (empty($ingredientId)) continue;

            $ingredient = $ingredientRepository->find($ingredientId);
            if (!$ingredient) continue;

            $items = $recette->getRecetteIngredients()->toArray();
            if (!isset($items[$index])) continue;

            $items[$index]->setIngredient($ingredient);
            $items[$index]->setRecette($recette);
        }
    }
}