<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CGVController extends AbstractController
{
    /**
     * @Route("/cgv", name="cgv")
     */
    public function index(): Response
    {
        return $this->render('reglementation/cgv.html.twig');
    }
}
