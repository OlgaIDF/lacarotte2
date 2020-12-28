<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminActusFormController extends AbstractController
{
    /**
     * @Route("/admin/actu/form", name="admin_actu_form")
     */
    public function index(): Response
    {
        return $this->render('admin/adminActuForm.html.twig',);
    }
}
