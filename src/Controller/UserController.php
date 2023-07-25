<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Session;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    #[Route('/user/ajoutUser', name: 'ajout_user')]
    #[Route('/user/{id}/edit', name: 'edit_user')]
    public function add(ManagerRegistry $doctrine, User $user = null, Request $request): Response
    {

        if(!$user) {
            $user = new user();
        }

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $entityManager = $doctrine->getManager();
            //equivalent prepare request pour éviter les failles SQL
            $entityManager->persist($user);
            // insert into (execute)
            $entityManager->flush();

            return $this->redirectToRoute('app_showListUser');
        }
        //vue pour affiche le formaulaire d'ajout 
        return $this->render('user/ajoutUser.html.twig', [
            'formAddUser' => $form->createView(),
            'edit' => $user->getId(),
        ]);
    }


    #[Route('/user/listUser', name: 'app_showListUser')]
    public function showListUser(ManagerRegistry $doctrine): Response
    {
        // $sessionRepository = $doctrine->getRepository(Session::class)->findByUserInSession();
        // dd($sessionRepository);
        $users = $doctrine->getRepository(User::class)->findAll();
        return $this->render('user/listUser.html.twig', [
            'users' => $users
        ]);
    }


    #[Route('/user/{id}', name: 'app_showProfile')]
    public function showProfile(User $user): Response
    {
        if($user){
            return $this->render('user/show.html.twig', [
                'user' => $user
            ]);
        } else {
            return $this->redirectToRoute('app_showListUser');
        }
    }


}
