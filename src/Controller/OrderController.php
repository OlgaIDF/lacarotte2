<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrderDetails;
use App\Repository\UserRepository;
use App\Repository\ItemMenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
  /**
   * @Route("/users/order", name="order")
   */
  public function index(SessionInterface $session, ItemMenuRepository $itemMenuRepository)
  {
    $cart = $session->get('cart', []);
    $cartWithData = [];
    foreach ($cart as $id => $quantity) {
      $cartWithData[] = [
        'menu' => $itemMenuRepository->find($id),
        'quantity' => $quantity
      ];
    }

    $total = 0;
    foreach ($cartWithData as $item) {
      $totalItem = $item['menu']->getPrice() * $item['quantity'];
      $total += $totalItem;
    }
    return $this->render('order/order.html.twig', [
      'items' => $cartWithData,
      'total' => $total


    ]);
  }

  /**
   * @Route("/users/order/new", name="order_new")
   */
  public function creerOrder(Request $request, SessionInterface $session, ItemMenuRepository $itemMenuRepository)
  {
    /* if ($request->isMethod('POST')) {
      $em = $this->getDoctrine()->getManager();
      $user = $this->getUser();
      $em->persist($user);
      $em->flush();
      return $this->redirectToRoute('home');
      } */

      {
        $cart = $session->get('cart', []);
       // $manager = $this->getDoctrine()->getManager();
       
    
            $order = new Orders();
            $order->setUser($this->getUser());
            $order->setCreatedAt(new \DateTime('now'));
            
          foreach ($cart as $id => $quantity) {
    
            $orderDetails = new OrderDetails;
    
            $orderDetails->setOrders($order);
            $orderDetails->setItemMenu($itemMenuRepository->find($id));
            $orderDetails->setQuantity($quantity);
            
            // $manager->persist($orderDetails);
            // $manager->flush();
    
            $order->getOrderDetails()->add($orderDetails);
            
          }
          dd($order);
        //  $manager->persist($order);
        //   $manager->flush();
          return $this->redirectToRoute("home");
           
        }
      }




    }



    


