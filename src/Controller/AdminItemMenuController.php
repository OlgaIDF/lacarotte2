<?php

namespace App\Controller;


use App\Entity\ItemMenu;
use App\Form\ItemMenuType;
use App\Repository\ItemMenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminItemMenuController extends AbstractController
{
    /**
     * @Route("/admin/menu", name="admin_menu")
     */
    public function index(ItemMenuRepository $itemMenuRepository)
    {
        $menu = $itemMenuRepository->findAll();

        return $this->render('admin/adminItemMenu.html.twig', [
            'menu' => $menu,
        ]);
    }
    /**
     * @Route("/admin/menu/create", name="menu_create")
     */
    public function createMenu(Request $request)
    {
        $menu = new ItemMenu();
        $form = $this->createForm(ItemMenuType::class, $menu);
        $form->handleRequest($request);

        $imgMenu = $form['img']->getData();

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $nomImgMenu = md5(uniqid()); // nom unique
                $extensionImgMenu = $imgMenu->guessExtension(); // récupérer l'extension du picto
                $newNomImgMenu = $nomImgMenu . '.' . $extensionImgMenu; // recomposer un nom du picto

                try { // on tente d'importer l'image


                    $imgMenu->move(
                        $this->getParameter('dossier_photos_menu'),
                        $newNomImgMenu
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue lors de l\'importation d\'image'
                    );
                }

                $menu->setImg($newNomImgMenu); // nom pour la base de données

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($menu);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Le menu a bien été ajouté'
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('admin_menu');
        }

        return $this->render('admin/adminItemMenuForm.html.twig', [
            'formulaireMenu' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/menu/update-{id}", name="menu_update")
     */
    public function updateMenu(ItemMenuRepository $itemMenuRepository, $id, Request $request)
    {
        $menu = $itemMenuRepository->find($id);

        $oldNomImgMenu = $menu->getImg();
        $oldCheminImgMenu = $this->getParameter('dossier_photos_menu') . '/' . $oldNomImgMenu;

        $form = $this->createForm(ItemMenuType::class, $menu);
        $form->handleRequest($request);

        $imgMenu = $form['img']->getData();

        if ($form->isSubmitted() && $form->isValid()) {

            if($imgMenu != null){

            if ($oldNomImgMenu != null) {
                unlink($oldCheminImgMenu);
            }


            $nomImgMenu = md5(uniqid()); // nom unique
            $extensionImgMenu = $imgMenu->guessExtension(); // récupérer l'extension du picto
            $newNomImgMenu = $nomImgMenu . '.' . $extensionImgMenu; // recomposer un nom du picto

            try { // on tente d'importer le picto                                      
                $imgMenu->move(
                    $this->getParameter('dossier_photos_menu'),
                    $newNomImgMenu
                );
            } catch (FileException $e) {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue lors de l\'importation d\'image'
                );
            }

            $menu->setImg($newNomImgMenu); // nom pour la base de données
        } else{
            $menu->setImg($oldNomImgMenu);
        }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($menu);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le menu a bien été modifié'
            );

            return $this->redirectToRoute('admin_menu');
        }
        return $this->render('admin/adminItemMenuForm.html.twig', [
            'formulaireMenu' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/menu/delete-{id}", name="menu_delete")
     */
    public function deleteMenu(ItemMenuRepository $itemMenuRepository, $id)
    {
        $menu = $itemMenuRepository->find($id);

        // récupérer le nom et le chemin de l'image à supprimer
        $nomImgMenu = $menu->getImg();
        $cheminImgMenu = $this->getParameter('dossier_photos_menu') . '/' . $nomImgMenu;

        // supprimer img1
        if ($nomImgMenu != null) {
            unlink($cheminImgMenu);
        }

        

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($menu);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le menu a bien été supprimé'
        );



        return $this->redirectToRoute('admin_menu');
    }
}
