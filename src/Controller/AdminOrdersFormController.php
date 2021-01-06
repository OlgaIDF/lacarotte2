<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminOrdersFormController extends AbstractController
{
    /**
     * @Route("/admin/orders/form", name="admin_orders_form")
     */
    public function index(): Response
    {
        return $this->render('admin/adminOrdersForm.html.twig');
       
    }
}
