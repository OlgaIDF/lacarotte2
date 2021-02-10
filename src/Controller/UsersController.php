<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Repository\UserRepository;
use App\Repository\OrdersRepository;
use App\Repository\CommandesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(): Response
    {
        return $this->render('users/user.html.twig');
    }

 /**
     * @Route("/users/modifier", name="users_profil_modifier")
     */
    public function editProfile(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Profil mis à jour'
            );
            return $this->redirectToRoute('users');
        }
        
        return $this->render('users/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/users/pass/modifier", name="users_pass_modifier")
     */
    public function editPass(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            // On vérifie si les 2 mots de passe sont identiques
            if($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('success', 'Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('users');
            }else{
                $this->addFlash('danger', 'Les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('users/editpass.html.twig');
    }

    /**
     * @Route("/users/delete-{id}", name="users_profile_delete")
     */
    public function deleteUser(UserRepository $userRepository, $id)
    {
        $user = $userRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre profil a bien été supprimé'
        );

        return $this->redirectToRoute('home');
    }

/**
     * @Route("/users/orders", name="users_commandes")
     */
    public function showOrders(OrdersRepository $ordersRepository): Response
    {
        $orders = $ordersRepository->findBySuccessOrders($this->getUser());
        // $orderDetails = [];
     
        return $this->render('users/orders.html.twig', [
            'orders' => $orders
        ]);
    }
     /**
     * @Route("/users/orders/{reference}", name="users_commandes_details")
     */
    public function details($reference, OrdersRepository $ordersRepository): Response
    {
        $order = $ordersRepository->findOneByReference($reference);
        if (!$order || $order->getUser() != $this->getUser() ) {
            return $this->redirectToRoute('users_commandes');
        }

        return $this->render('users/orders_details.html.twig', [
            'reference' => $reference,
            'order' => $order
        ]);
    }





}