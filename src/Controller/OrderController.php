<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    
    
  public function createOrderItem(Request $request, SessionInterface $session, ItemMenuRepository $itemMenuRepository)
  {
    $cart = $session->get('cart', []);

    if ($request->isMethod('POST')) {

      foreach ($cart as $id => $quantity) {


        $orderDetails = new OrderDetails;
        $orderDetails->setItemMenu($itemMenuRepository->find($id));
        $orderDetails->setQuantity($quantity);
 dd($orderDetails);
      }
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($orderDetails);
        $manager->flush();
       
    }
  }
}
