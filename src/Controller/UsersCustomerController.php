<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use App\Repository\ItemMenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersCustomerController extends AbstractController
{
    /**
     * @Route("/users/destinataire", name="users_destinataire")
     */
    public function index(): Response
    {
        // get all addresses from the user
        $customers = $this->getUser()->getCustomers();
        return $this->render('users/customer.html.twig', [

            'customers' => $customers
        ]);
    }

    /**
     * @Route("/users/add_destinataire", name="add_destinataire")
     */
    public function add(Request $request, EntityManagerInterface $manager, SessionInterface $session)
    {
        $user = $this->getUser();

        $customer = new Customer();
        $form = $this->createform(CustomerType::class, $customer);
        $form->handleRequest($request);

        $cart = $session->get('cart', []);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $customer->setUser($user);
            $manager->persist($customer);
            $manager->flush();
            if ($cart) {
                return $this->redirectToRoute('order');
            }
            $this->addFlash("success", "De nouvelles coordonnées d'expédition ont été ajoutées");
            return $this->redirectToRoute('users_destinataire');
        }

        return $this->render('users/customerForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/users/edit_destinataire/{id}", name="edit_destinataire")
")
     */
    public function edit(CustomerRepository $customerRepository, $id, EntityManagerInterface $manager, Request $request)
    {
        $customer = $customerRepository->find($id);
        $form = $this->createform(CustomerType::class, $customer);
        $form->handleRequest($request);
        if (!$customer || $customer->getUser() != $this->getUser()) {
            return $this->redirectToRoute('users_destinataire');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash("success", "Les coordonnées d'expédition ont été modifiées");
            return $this->redirectToRoute('users_destinataire');
        }
        return $this->render('users/customerForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/remove_destinataire/{id}", name="delete_destinataire")
     */
    public function remove(CustomerRepository $customerRepository, EntityManagerInterface $manager, $id): Response
    {
        $customer = $customerRepository->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($customer);
        $manager->flush();

        $this->addFlash(
            'success',
            "Votre coordonnées d'expédition ont été suppriméés"
        );
        return $this->redirectToRoute('users_destinataire');
    }
}
