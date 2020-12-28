<?php

namespace App\Controller;


use App\Entity\Actus;
use App\Form\ActuType;
use App\Repository\ActusRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminActusController extends AbstractController
{
    /**
     * @Route("/admin/actus", name="admin_actus")
     */
    public function index(ActusRepository $actusRepository)
    {
        $actus = $actusRepository->findAll();

        return $this->render('admin/adminActus.html.twig', [
            'actus' => $actus,
        ]);
    }
    /**
     * @Route("/admin/actus/create", name="actu_create")
     */
    public function createActu(Request $request) //creation des actus
    {
        $actu = new Actus();
        $actu->setCreatedAt(new \DateTime('now'));
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        $imgActu = $form['img']->getData();

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $nomImgActu
                    = md5(uniqid()); // nom unique
                $extensionImgActu
                    = $imgActu->guessExtension(); // récupérer l'extension du picto
                $newNomImgActu
                    = $nomImgActu
                    . '.' . $extensionImgActu; // recomposer un nom du picto

                try { // on tente d'importer l'image


                    $imgActu->move(
                        $this->getParameter('dossier_photos_actus'),
                        $newNomImgActu

                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue lors de l\'importation d\'image'
                    );
                }

                $actu->setImg($newNomImgActu); // nom pour la base de données

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($actu);
                $manager->flush();
                $this->addFlash(
                    'success',
                    "L'actu a bien été ajouté"
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('admin_actus');
        }

        return $this->render('admin/adminActusForm.html.twig', [
            'formulaireActu' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/actus/update-{id}", name="actu_update")
     */
    public function updateActu(ActusRepository $actusRepository, $id, Request $request) // modifier des actus
    {
        $actu = $actusRepository->find($id);

        $oldNomImgactu = $actu->getImg();
        $oldCheminImgactu = $this->getParameter('dossier_photos_actus') . '/' . $oldNomImgactu;

        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        $imgActu = $form['img']->getData();

        if ($form->isSubmitted() && $form->isValid()) {

            if ($oldNomImgactu != null) {
                unlink($oldCheminImgactu);
            }


            $nomImgActu
                = md5(uniqid()); // nom unique
            $extensionImgActu
                = $imgActu->guessExtension(); // récupérer l'extension du picto
            $newNomImgActu
                = $nomImgActu
                . '.' . $extensionImgActu; // recomposer un nom du picto

            try { // on tente d'importer le picto                                      
                $imgActu->move(
                    $this->getParameter('dossier_photos_actus'),
                    $newNomImgActu

                );
            } catch (FileException $e) {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue lors de l\'importation d\'image'
                );
            }

            $actu->setImg($newNomImgActu); // nom pour la base de données

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($actu);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'actu a bien été modifié"
            );

            return $this->redirectToRoute('admin_actus');
        }
        return $this->render('admin/adminActusForm.html.twig', [
            'formulaireActu' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/actus/delete-{id}", name="actu_delete")
     */
    public function deleteActu(ActusRepository $actusRepository, $id)
    {
        $actu = $actusRepository->find($id);

        // récupérer le nom et le chemin de l'image à supprimer
        $nomImgActu
            = $actu->getImg();
        $cheminImgactu = $this->getParameter('dossier_photos_actus') . '/' . $nomImgActu;

        // supprimer img1
        if (
            $nomImgActu
            != null
        ) {
            unlink($cheminImgactu);
        }



        $manager = $this->getDoctrine()->getManager();
        $manager->remove($actu);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'actu a bien été supprimé"
        );



        return $this->redirectToRoute('admin_actus');
    }
}
