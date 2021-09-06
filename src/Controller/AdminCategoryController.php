<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCategoryController extends AbstractController
{

    /**
     * @Route("/admin/categories", name="admin_category")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository
            ->findAll();

        return $this->render('admin/adminCategory.html.twig', [
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/admin/categories/create", name="category_create")
     */
    public function createCategory(Request $request) //creation de category
    {
        $category = new Category();
        
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($category);
                $manager->flush();
                $this->addFlash(
                    'success',
                    "La catégorie a bien été ajouté"
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/adminCategoryForm.html.twig', [
            'formulaireCategory' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/categories/update-{id}", name="category_update")
     */
    public function updateCategory(CategoryRepository $categoryRepository,
        $id,
        Request $request
    ) // modifier des categories
    {
        $category = $categoryRepository
            ->find($id);

        

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

       
        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash(
                'success',
                "La catégorie a bien été modifié"
            );

            return $this->redirectToRoute('admin_category');
        }
        return $this->render('admin/adminCategoryForm.html.twig', [
            'formulaireCategory' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/categories/delete-{id}", name="category_delete")
     */
    public function deleteCategory(CategoryRepository $categoryRepository, $id) {//supprimer les categories
        $category = $categoryRepository
            ->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($category);
        $manager->flush();

        $this->addFlash(
            'success',
            "La catégorie a bien été supprimé"
        );



        return $this->redirectToRoute('admin_category');
    }
}
