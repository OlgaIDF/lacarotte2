<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDeliveryFormController extends AbstractController
{
    /**
     * @Route("/admin/delivery/form", name="admin_delivery_form")
     */
    public function index(): Response
  
    {
        return $this->render('admin/adminDeliveryForm.html.twig');
    }
}
