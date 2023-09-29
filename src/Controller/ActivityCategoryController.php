<?php

namespace App\Controller;

use App\Entity\ActivityCategory;
use App\Form\ActivityCategoryType;
use App\Repository\ActivityCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class ActivityCategoryController extends AbstractController
{
    #[Route('/create', name: 'category_create')]
    #[Route('/update/{id}', name: 'category_update')]
    public function index(Request $request, EntityManagerInterface $manager, ActivityCategoryRepository $repository, $id = null): Response
    {

        $categories = $repository->findAll();

        if ($id) {
            $category = $repository->find($id);
        } else {
            $category = new ActivityCategory();
        }

        $form = $this->createForm(ActivityCategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('info', 'Opération réalisée avec succès');
            return $this->redirectToRoute('category_create');
        }

        return $this->render('activity_category/index.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
            'title'=>'Gestion des catégories d\'activité'
        ]);
    }

    #[Route('/delete/{id}', name: 'category_delete')]
    public function delete(EntityManagerInterface $manager, ActivityCategory $category): Response
    {
        $manager->remove($category);
        $manager->flush();
        $this->addFlash('info', 'Opération réalisée avec succès');

        return $this->redirectToRoute('category_create');
    }
}
