<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminItemMenuFormController extends AbstractController
{
    /**
     * @Route("/admin/menu/form", name="admin_menu_form")
     */
    public function index(): Response
    {
        return $this->render('admin/adminItemMenuForm.html.twig',);
    }
}
