<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/city')]
class CityController extends AbstractController
{
    #[Route('/', name: 'city_create')]
    #[Route('/update/{id}', name: 'city_update')]
    public function index(Request $request, EntityManagerInterface $manager, CityRepository $repository, $id = null): Response
    {

        $cities = $repository->findAll();

        if ($id) {
            $city = $repository->find($id);

        } else {


            $city = new City();
        }


        $form = $this->createForm(CityType::class, $city);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($city);
            $manager->flush();

            if ($id) {
                $this->addFlash('success', 'Ville modifiée');

            } else {

                $this->addFlash('success', 'Ville ajoutée');
            }


            return $this->redirectToRoute('media_type_choice', ['param'=>'ville', 'id'=>$city->getId()]);


        }


        return $this->render('city/index.html.twig', [
            'form' => $form->createView(),
            'cities' => $cities,
            'title'=>'Gestion des villes'
        ]);

    }


    #[Route('/delete/{id}', name: 'city_delete')]
    public function deleteCity(CityRepository $cityRepository,MediaRepository $mediaRepository, EntityManagerInterface $manager,$id ): Response
    {
        $city=$cityRepository->find($id);

        $media=$mediaRepository->findOneBy(['city'=>$city]);


       unlink($this->getParameter('upload_dir').'/'.$media->getName());


        $manager->remove($city);

        $manager->flush();
        $this->addFlash('success', 'Ville supprimée');

        return $this->redirectToRoute('city_create');
    }


}
