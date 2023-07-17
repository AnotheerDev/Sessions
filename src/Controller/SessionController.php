<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionFormType;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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


    #[Route('/session/ajoutSession', name: 'ajout_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function add(ManagerRegistry $doctrine, session $session = null, Request $request): Response
    {

        if(!$session) {
            $session = new session();
        }

        $form = $this->createForm(SessionFormType::class, $session);
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){
            $session = $form->getData();
            $entityManager = $doctrine->getManager();
            //equivalent prepare request pour éviter les failles SQL
            $entityManager->persist($session);
            // insert into (execute)
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }
        //vue pour affiche le formaulaire d'ajout 
        return $this->render('session/ajoutSession.html.twig', [
            'formAddSession' => $form->createView(),
            'edit' => $session->getId(),
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
