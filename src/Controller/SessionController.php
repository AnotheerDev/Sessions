<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $sessions = $doctrine->getRepository(Session::class)->findAll();
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions
        ]);
    }

    
    #[Route('/showSession/{id}', name: 'app_showSession')]
    public function show(Session $session=null, SessionRepository $sr): Response
    {
        $session_id=$session->getId();
        $nonInscrits= $sr->findNonInscrits($session_id);
        $autresModules= $sr->findAutresModules($session_id);
        
        return $this->render('session/showSession.html.twig', [
            'session' => $session,
            'nonInscrits' => $nonInscrits,
            'autresModules' => $autresModules,
        ]);
    }
}
