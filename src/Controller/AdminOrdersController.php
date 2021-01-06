<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Form\OrdersAdminType;
use App\Repository\OrdersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminOrdersController extends AbstractController
{
    /**
     * @Route("/admin/orders", name="admin_orders")
     */
    public function index(OrdersRepository $ordersRepository)
    {
        $orders = $ordersRepository->findAll();

        return $this->render('admin/adminOrders.html.twig', [
            'orders' => $orders,
        ]);
    }
    

    /**
     * @Route("/admin/orders/update-{id}", name="order_update")
     */
    public function updateOrder(OrdersRepository $ordersRepository, $id, Request $request)
    {
        $order = $ordersRepository->find($id);



        $form = $this->createForm(OrdersAdminType::class, $order);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($order);
            $manager->flush();
            $this->addFlash(
                'success',
                "Le commande a bien été modifié"
            );

            return $this->redirectToRoute('admin_orders');
        }
        return $this->render('admin/adminOrdersForm.html.twig', [
            'formulaireOrder' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/orders/delete-{id}", name="order_delete")
     */
    public function deleteOrder(OrdersRepository $ordersRepository, $id)
    {
        $order = $ordersRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($order);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le commande a bien été supprimé"
        );



        return $this->redirectToRoute('admin_orders');
    }
}
