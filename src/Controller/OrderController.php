<?php

namespace App\Controller;

use DateTime;
use App\Entity\Orders;
use App\Form\OrdersType;
use App\Entity\OrderDetails;
use App\Repository\UserRepository;
use App\Repository\ItemMenuRepository;
use Doctrine\ORM\EntityManagerInterface;
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


  $form = $this->createForm(OrdersType::class, null, [
      'user' => $this->getUser()
  ]);
    return $this->render('order/order.html.twig', [
      'form' => $form->createView(),
      'items' => $cartWithData,
      'total' => $total


    ]);
  }

/**
     * @Route("/users/order/recap", name="order_recap", methods={"POST", "GET"})
     */
    public function addOrder(SessionInterface $session, Request $request, EntityManagerInterface $manager, ItemMenuRepository $itemMenuRepository): Response

    {
        
    
  $form = $this->createForm(OrdersType::class, null, [
      'user' => $this->getUser()
  ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $customer = $form->get('customer')->getData();
            $customer_content = $customer->getFirstName().' '.$customer->getLastName();

            
            $customer_content .= '</br>'.$customer->getAddress();
            $customer_content .= '</br>'.$customer->getPostalCode().' '.$customer->getCity();
            $customer_content .= '</br>'.$customer->getPhone();
            // dd($customer_content);

            $order = new Orders();
            $date = new DateTime();
            $reference =  $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
           
            $order->setCustomer($customer_content);
           
          
            // save products in orderdetails
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

    foreach ($cartWithData as $item) {
                $orderDetails = new OrderDetails();
                $orderDetails->setOrders($order);
              
                $orderDetails->setQuantity($item['quantity']);
                $orderDetails->setItemMenu($item['menu']);
                $manager->persist($orderDetails);

                //dd($item);
            }
            $manager->flush();

            $session->invalidate();

            return $this->render('order/order-recap.html.twig', [
                'form' => $form->createView(),
                'items' => $cartWithData,
                'total' => $total,
                
                'customer' =>$customer_content,
                'reference' => $order->getReference()
            ]);
        }
        

        return $this->redirectToRoute('home');
     
    }
}