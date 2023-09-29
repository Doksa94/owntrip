<?php
//src/controller
namespace App\Controller;

use App\Entity\MediaType;
use App\Form\MediaTType;
use App\Repository\MediaTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/media_type')]
class MediaTypeController extends AbstractController
{
    #[Route('/update/{id}', name: 'media_type_update')]
    #[Route('/create', name: 'media_type_create')]
    public function index(Request $request, EntityManagerInterface $manager, MediaTypeRepository $repository, $id=null): Response
    {

        $mediastypes=$repository->findAll();

        if($id){

            $mediatype=$repository->find($id);
        }else{

            $mediatype=new MediaType();
        }

        $form=$this->createForm(MediaTType::class, $mediatype);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {

            $manager->persist($mediatype);
            $manager->flush();
            $this->addFlash('info', 'Opération réalisée avec succès');
            return $this->redirectToRoute('media_type_create');

        }


        return $this->render('media_type/index.html.twig', [
            'form'=>$form->createView(),
            'mediastypes'=>$mediastypes,
            'title'=>'Gestion types de média'
        ]);
    }

    #[Route('/delete/{id}', name: 'media_type_delete')]
    public function deleteMediaType(MediaType $mediatype, EntityManagerInterface $manager): Response
    {

        $manager->remove($mediatype);
        $manager->flush();
        $this->addFlash('info', 'Opération réalisée avec succès');

        return $this->redirectToRoute('media_type_create');
    }
}
