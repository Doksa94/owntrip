<?php

namespace App\Controller;

use App\Entity\ActivityType;
use App\Form\ActivityTypType;
use App\Repository\ActivityTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/activity/type')]
class ActivityTypeController extends AbstractController
{
    #[Route('/update/{id}', name: 'type_update')]
    #[Route('/', name: 'type_create')]
    public function index(Request $request, EntityManagerInterface $manager,ActivityTypeRepository $repository, $id=null): Response
    {

        $types=$repository->findAll();

        if ($id){

            $type=$repository->find($id);

        }else{

            $type=new ActivityType();
        }



        $formulaire_type=$this->createForm(ActivityTypType::class, $type);

        $formulaire_type->handleRequest($request);

        if ($formulaire_type->isSubmitted() && $formulaire_type->isValid())
        {

            $manager->persist($type);
            $manager->flush();
            $this->addFlash('info', 'Opération réalisée avec succès');
            return $this->redirectToRoute('type_create');




        }


        return $this->render('activity_type/index.html.twig', [
            'formulaire_type'=>$formulaire_type->createView(),
            'types'=>$types,
             'title'=>'Gestion des types d\'activité'
        ]);

    }

    #[Route('/delete/{id}', name: 'activity_type_delete')]
    public function delete_type(ActivityType $type, EntityManagerInterface $manager): Response
    {
        $manager->remove($type);
        $manager->flush();
        $this->addFlash('info', 'Opération réalisée avec succès');

        return $this->redirectToRoute('type_create');
    }






}// fermeture du controller
