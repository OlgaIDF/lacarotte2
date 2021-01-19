<?php
namespace App\Controller;
use App\Entity\OrderDetails;
use App\Repository\ItemMenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
  /**
   * @Route("/cart", name="cart_index")
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
    $session->set('total', $total);
    
    return $this->render('cart/cart.html.twig', [
      'items' => $cartWithData,
      'total' => $total
    ]);
  }
    /**
   * @Route("/cart/add/{id}", name="cart_add")
   */
  public function add($id, SessionInterface $session)
  {
    $cart = $session->get('cart', []);
    if (!empty($cart[$id])) {
      $cart[$id]++;
    } else {
      $cart[$id] = 1;
    }
    $session->set('cart', $cart);
    return $this->redirectToRoute("cart_index");
  }
  /**
   * @Route("/cart/delete/{id}", name="cart_delete")
   */
  public function delete($id, SessionInterface $session)
  {
    $cart = $session->get('cart', []);
    if (!empty($cart[$id])) {
      unset($cart[$id]);
    }
    $session->set('cart', $cart);
    return $this->redirectToRoute("cart_index");
  }
  /**
     * @Route("/cart/deleteOne/{id}", name="delete_one")
     */
  public function deleteOne($id,  SessionInterface $session)
  {
      $cart = $session->get('cart', []);
      if (($cart[$id]) > 1) {
          $cart[$id]--;
      }else{
          // $cart[$id] = 0;
          unset($cart[$id]);
      }
      $session->set('cart', $cart);
      return $this->redirectToRoute("cart_index");
  }
}
