<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryFormController extends AbstractController

{
    /**
     * @Route("/admin/category/form", name="admin_category_form")
     */
    public function index(): Response
    {
        return $this->render('admin/adminCategoryForm.html.twig',);
    }
}
