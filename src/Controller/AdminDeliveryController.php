<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Form\DeliveryType;
use App\Repository\DeliveryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDeliveryController extends AbstractController
{

    /**
     * @Route("/admin/deliveries", name="admin_delivery")
     */
    public function index(DeliveryRepository $deliveryRepository)
    {
        $deliveries = $deliveryRepository->findAll();

        return $this->render('admin/adminDelivery.html.twig', [
            'deliveries' => $deliveries,
        ]);
    }
    /**
     * @Route("/admin/deliveries/create", name="delivery_create")
     */
    public function createDelivery(Request $request) 
    {
        $delivery = new Delivery();
        
        $form = $this->createForm(DeliveryType::class, $delivery);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($delivery);
                $manager->flush();
                $this->addFlash(
                    'success',
                    "Le transporteur a bien été ajouté"
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('admin_delivery');
        }

        return $this->render('admin/adminDeliveryForm.html.twig', [
            'formulaireDelivery' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/deliveries/update-{id}", name="delivery_update")
     */
    public function updateDelivery(DeliveryRepository $deliveryRepository, $id, Request $request) 
    {
        $delivery = $deliveryRepository->find($id);

        

        $form = $this->createForm(DeliveryType::class, $delivery
);
        $form->handleRequest($request);

       
        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($delivery);
            $manager->flush();
            $this->addFlash(
                'success',
                "Le transporteur a bien été modifié"
            );

            return $this->redirectToRoute('admin_delivery');
        }
        return $this->render('admin/adminDeliveryForm.html.twig', [
            'formulaireDelivery' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/deliveries/delete-{id}", name="delivery_delete")
     */
    public function deleteDelivery(DeliveryRepository $deliveryRepository, $id) {
        $delivery= $deliveryRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($delivery);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le transporteur a bien été supprimé"
        );



        return $this->redirectToRoute('admin_delivery');
    }
}

