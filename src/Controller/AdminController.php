<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response


    {
        return $this->render('admin/dashboard.html.twig', [
            'title' => 'Dashboard'
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(EntityManagerInterface $manager, Request $request, UserPasswordHasherInterface $hasher): Response
    {

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // hachage du mot de passe
            // la méthode hashPassword attend en 1er argument l'entité à scanner pour vérifier qu'elle
            // implémente bien la PasswordAuthenticatedUserInterface et ainsi qu'il puisse verifier l'algorithme
            // de cryptage utilisé défini dans le security.yaml
            $mdp = $hasher->hashPassword($user, $form->get('password')->getData());

            // on recharge sur l'objet le nouveau de passe haché
            $user->setPassword($mdp);
            $manager->persist($user);
            $manager->flush();

        }


        return $this->render('admin/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(): Response
    {


        return $this->render('admin/login.html.twig', [

        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {


    }


    #[Route('/reset/password', name: 'reset_password')]
    public function reset(Request $request, TransportInterface $mailer, UserRepository $repository): Response
    {

        if (!empty($_POST)) {

            $email = $request->request->get('email');
            $user = $repository->findOneBy(['email' => $email]);

            if ($user) {
               // dd($email);

                $email = (new TemplatedEmail())
                    ->from('owntrip@coorg.com')
                    ->to($email)
                    ->subject('Récupération de mot de passe')
                    ->htmlTemplate('email/resetPassword.html.twig')
                    ->context([
                        'user' => $user
                    ]);
                $mailer->send($email);
                $this->addFlash('success', 'Un mail de réinitialisation viens de vous être transmis');


            } else {
                $this->addFlash('danger', 'Aucun compte à cette adresse mail');
                return $this->redirectToRoute('reset_password');
            }


        }


        return $this->render('admin/forgotPassword.html.twig', [

        ]);
    }

    #[Route('/password/new/{id}', name: 'new_password')]
    public function new_password(UserRepository $userRepository,Request $request,EntityManagerInterface $manager,UserPasswordHasherInterface $hasher,$id): Response
    {

        // en théorie un champs token devrait exister en BDD, token qui aurait été généré à la demande de réinitialisation ainsi q'une date d'expiration
        // puis la recherche de user aurait été findOneBy(['token'=>$token]);
        if (!empty($_POST))
        {

            $user=$userRepository->find($id);
            $mdp=$hasher->hashPassword($user, $request->request->get('password'));
            $user->setPassword($mdp);
            // ici le token aurait été remis à null
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('info', 'Mot de passe réinitialisé, connectez-vous à présent');
            return $this->redirectToRoute('login');

        }


        return $this->render('admin/new_password.html.twig', [
             'id'=>$id
        ]);
    }


}
