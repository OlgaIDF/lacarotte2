<?php

namespace App\Controller;

use DateTime;
use App\Entity\Orders;
use App\Form\OrdersType;
use App\Entity\OrderDetails;
use App\Repository\UserRepository;
use App\Repository\CustomerRepository;
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
   * @Route("/order", name="order")
   */
  public function index(SessionInterface $session, ItemMenuRepository $itemMenuRepository)
  {
    if (!$this->getUser()->getCustomers()->getValues()) {
      return $this->redirectToRoute('add_destinataire');
  }
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
$id=$this->getUser()->getId();

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
     * @Route("/order/recap", name="order_recap", methods={"POST", "GET"})
     */
    public function addOrder(SessionInterface $session, Request $request, EntityManagerInterface $manager, ItemMenuRepository $itemMenuRepository): Response

    {
        
      if (!$this->getUser()->getCustomers()->getValues()) {
        return $this->redirectToRoute('add_destinataire');
    }
  $form = $this->createForm(OrdersType::class, null, [
      'user' => $this->getUser()
  ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $customer = $form->get('customer')->getData();
            $customer_content = $customer->getFirstName().' '.$customer->getLastName();
            $customer_content .= '</br>'.$customer->getPhone();
            // dd($customer_content);

            $order = new Orders();
            $date = new DateTime();
            $reference =  $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setState(0);
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
      $orderDetails = new OrderDetails();
      $orderDetails->setOrders($order);
      $orderDetails->setMenu($item['menu']->getName());
      $orderDetails->setQuantity($item['quantity']);
      $orderDetails->setItemMenu($item['menu']);
      $orderDetails->setPrice($item['menu']->getPrice());
      $orderDetails->setTotal($item['menu']->getPrice() * $item['quantity']);
      $manager->persist($orderDetails);
      $totalItem = $item['menu']->getPrice() * $item['quantity'];
      $total += $totalItem;
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