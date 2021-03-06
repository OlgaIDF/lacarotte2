<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\ActusRepository;
use App\Repository\CategoryRepository;
use App\Repository\ItemMenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(\Swift_Mailer $mailer, Request $request, ActusRepository $actusRepository, ItemMenuRepository $itemMenuRepository, CategoryRepository $categoryrepository): Response

    {
        $formulaireContact = $this->createForm(ContactType::class);
        $formulaireContact->handleRequest($request);

        if ($formulaireContact->isSubmitted() && $formulaireContact->isValid()) {
            $infos = $formulaireContact->getData();
            // On crée le message
            $mail = (new \Swift_Message('Nouveau contact'))
                ->setFrom(htmlspecialchars($infos['email']))
                ->setTo('restaurant.lacarotte@gmail.com')
                ->setBody(
                    $this->renderView(
                        'contact/email.html.twig',
                        [
                            'prenom' => htmlspecialchars($infos['prenom']),
                            'email' => htmlspecialchars($infos['email']),
                            'message' => htmlspecialchars($infos['message'])
                        ],
                        'text/html'
                    )
                );
            $mailer->send($mail);
            $this->addFlash(
                'success',
                'Votre message a bien été envoyé'
            ); // Permet un message flash de renvoi
            return $this->redirectToRoute('home');
        }

        $actus = $actusRepository->findSix();
        $itemMenu = $itemMenuRepository ->findAll();
        $category=$categoryrepository->findAll();

        return $this->render('home/index.html.twig', [
            "item_menu" => $itemMenu,
            'actus' => $actus,
            'category' => $category,
            'formulaireDeContact' => $formulaireContact->createView()

        ]);
    }
}
