<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolitiqueConfidentialite extends AbstractController
{
    /**
     * @Route("/politique_confidentialite", name="politique_confidentialite")
     */
    public function index(): Response
    {
        return $this->render('reglementation/politique_confidentialite.html.twig');
    }
}
