<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Repository\ActivityRepository;
use App\Repository\ActivityTypeRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }


    #[Route('/activities/result', name: 'activities_result')]
    #[Route('/activities/filter', name: 'activities_filter')]
    #[Route('/activities/{city}', name: 'activities_redir')]
    public function activities_result(ActivityRepository $activityRepository, ActivityTypeRepository $typeRepository, Request $request, CartService $cartService, $city = null): Response
    {
        if (!$city) {

            $city = $request->request->get('city');
        }

        $types = $typeRepository->findAll();

        if ($request->request->has('type')) {
            $activities = array();
            foreach ($request->request->all()['type'] as $type) {

                $results = $activityRepository->findByCityAndType($city, $type);
                foreach ($results as $result) {
                    $activities[] = $result;
                }

            }

        } else {

            $activities = $activityRepository->findByCity($city);

        }

        $wishes = $cartService->getCartWithData();

        //dd($wishes);


        return $this->render('front/activities_result.html.twig', [
            'activities' => $activities,
            'types' => $types,
            'city' => $city,
            'wishes' => $wishes
        ]);
    }

    #[Route('/add/wish/{id}/{city}', name: 'add_wish')]
    public function add_wish(CartService $cartService, $id, $city): Response
    {
        $cartService->add($id);
        $this->addFlash('info', 'Ajouté en favori');
        return $this->redirectToRoute('activities_redir', ['city' => $city]);
    }

    #[Route('/remove/wish/{id}/{city}', name: 'remove_wish')]
    public function remove_wish(CartService $cartService, $id, $city): Response
    {
        $cartService->remove($id);
        $this->addFlash('info', 'Retiré des favoris');
        return $this->redirectToRoute('activities_redir', ['city' => $city]);
    }

    #[Route('/wishList', name: 'wishList')]
    public function wishList(CartService $cartService): Response
    {
        $wishes = $cartService->getCartWithData();


        return $this->render('front/wishList.html.twig', [
            'wishes' => $wishes
        ]);
    }

    #[Route('/wishList/detail/{id}', name: 'wishList_detail')]
    public function wishList_detail(Activity $activity): Response
    {



        return $this->render('front/activity_details.html.twig', [
           'activity'=>$activity,
            'title'=>'détail de l\'activité'
        ]);
    }


}
