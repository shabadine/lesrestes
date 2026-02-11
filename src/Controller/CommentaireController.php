<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/commentaire')]
#[IsGranted('ROLE_USER')]
final class CommentaireController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($commentaire->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Modification interdite.');
        }

        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Commentaire mis à jour !');

            return $this->redirectToRoute('app_recette_show', ['id' => $commentaire->getRecette()->getId()]);
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_commentaire_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($commentaire->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Suppression interdite.');
        }

        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $recetteId = $commentaire->getRecette()->getId();
            $entityManager->remove($commentaire);
            $entityManager->flush();
            $this->addFlash('success', 'Commentaire supprimé.');

            return $this->redirectToRoute('app_recette_show', ['id' => $recetteId]);
        }

        return $this->redirectToRoute('app_recette_show', ['id' => $commentaire->getRecette()->getId()]);
    }
}
