<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/country')]
class CountryController extends AbstractController
{


    #[Route('/update/{id}', name: 'country_update')]
    #[Route('/', name: 'country_create')]
    public function index(Request $request, EntityManagerInterface $manager,CountryRepository $repository, $id=null): Response
    {

        $countries=$repository->findAll();

        if ($id){

            $country=$repository->find($id);

        }else{

            $country=new Country();
        }



        $form=$this->createForm(CountryType::class, $country);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $manager->persist($country);
            $manager->flush();
            $this->addFlash('info', 'Opération réalisée avec succès');
            return $this->redirectToRoute('country_create');




        }


        return $this->render('country/index.html.twig', [
           'formu'=>$form->createView(),
            'countries'=>$countries,
            'title'=>'Gestion des pays'
        ]);

    }

    #[Route('/delete/{id}', name: 'country_delete')]
    public function delete_country(Country $country, EntityManagerInterface $manager): Response
    {
        $manager->remove($country);
        $manager->flush();
        $this->addFlash('info', 'Opération réalisée avec succès');

        return $this->redirectToRoute('country_create');
    }




}
