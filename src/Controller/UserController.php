<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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


    #[Route('/user/listUser', name: 'app_showListUser')]
    public function showListUser(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findAll();
        return $this->render('user/listUser.html.twig', [
            'users' => $users
        ]);
    }


    #[Route('/user/{id}', name: 'app_showProfile')]
    public function showProfile(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }
}
