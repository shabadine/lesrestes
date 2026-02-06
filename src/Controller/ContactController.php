<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            
            $data = $form->getData() ?? $request->request->all('contact');

            if ($data) {
                $email = (new Email())
                    ->from($data['email'] ?? 'test@lesrestes.fr')
                    ->to('admin@les-restes.fr') 
                    ->subject('Nouveau message : ' . ($data['sujet'] ?? 'Sans sujet'))
                    ->text(
                        "Message de : " . ($data['nom'] ?? 'Inconnu') . "\n" .
                        "Email : " . ($data['email'] ?? 'Non fourni') . "\n\n" .
                        ($data['message'] ?? 'Pas de contenu')
                    );

                try {
                    $mailer->send($email);
                    $this->addFlash('success', 'Votre message a été envoyé avec succès !');
                    return $this->redirectToRoute('app_contact');
                } catch (\Exception $e) {
                    $this->addFlash('danger', 'Erreur d\'envoi : ' . $e->getMessage());
                }
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}