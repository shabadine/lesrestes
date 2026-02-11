<?php

namespace App\Controller;

use App\Form\UserProfileType;
use App\Repository\FavoriRepository;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class ProfilController extends AbstractController
{
    public function __construct(
        private RecetteRepository $recetteRepository,
        private FavoriRepository $favoriRepository,
    ) {
    }

    #[Route('/profil', name: 'app_profil')]
    public function index(
        PaginatorInterface $paginator,
        Request $request,
    ): Response {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $mesRecettesQuery = $this->recetteRepository
            ->createUserRecettesQueryBuilder($user)
            ->getQuery();

        $mesRecettes = $paginator->paginate(
            $mesRecettesQuery,
            $request->query->getInt('page', 1),
            3
        );

        $mesFavorisQuery = $this->favoriRepository
            ->createUserFavorisQueryBuilder($user)
            ->getQuery();

        $mesFavoris = $paginator->paginate(
            $mesFavorisQuery,
            $request->query->getInt('page_favoris', 1),
            3
        );

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'mesRecettes' => $mesRecettes,
            'mesFavoris' => $mesFavoris,
        ]);
    }

    #[Route('/profil/modifier', name: 'app_profil_edit')]
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        SluggerInterface $slugger,
    ): Response {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photoFile')->getData();
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads/profils',
                        $newFilename
                    );

                    if ($user->getPhoto()) {
                        $oldPhoto = $this->getParameter('kernel.project_dir').'/public/uploads/profils/'.$user->getPhoto();
                        if (is_file($oldPhoto)) {
                            unlink($oldPhoto);
                        }
                    }

                    $user->setPhoto($newFilename);
                } catch (FileException) {
                    $this->addFlash('danger', 'Erreur lors de l\'upload de la photo.');
                }
            }

            $currentPassword = $form->get('currentPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();
            $confirmPassword = $form->get('confirmPassword')->getData();

            if ($newPassword) {
                if (!$currentPassword) {
                    $this->addFlash('danger', 'Veuillez entrer votre mot de passe actuel.');

                    return $this->render('profil/edit.html.twig', [
                        'form' => $form,
                        'user' => $user,
                    ]);
                }

                if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                    $this->addFlash('danger', 'Le mot de passe actuel est incorrect.');

                    return $this->render('profil/edit.html.twig', [
                        'form' => $form,
                        'user' => $user,
                    ]);
                }

                if ($newPassword !== $confirmPassword) {
                    $this->addFlash('danger', 'Les mots de passe ne correspondent pas.');

                    return $this->render('profil/edit.html.twig', [
                        'form' => $form,
                        'user' => $user,
                    ]);
                }

                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
            }

            $em->flush();
            $this->addFlash('success', 'Profil modifié avec succès !');

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/edit.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/profil/supprimer', name: 'app_profil_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->isCsrfTokenValid('delete_account'.$user->getId(), $request->request->get('_token'))) {
            if ($user->getPhoto()) {
                $photoPath = $this->getParameter('kernel.project_dir').'/public/uploads/profils/'.$user->getPhoto();
                if (is_file($photoPath)) {
                    unlink($photoPath);
                }
            }

            $em->remove($user);
            $em->flush();

            $request->getSession()->invalidate();
            $this->container->get('security.token_storage')->setToken(null);

            $this->addFlash('success', 'Votre compte et toutes vos données ont été supprimés conformément au RGPD.');

            return $this->redirectToRoute('app_home');
        }

        $this->addFlash('danger', 'Jeton de sécurité invalide.');

        return $this->redirectToRoute('app_profil_edit');
    }
}
