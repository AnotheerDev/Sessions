<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Programme;
use App\Form\SessionFormType;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



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


    #[Route("/session/removeModule/{idSe}/{idMo}", name: 'removeModule')]
    //ParamConverter sert un peu comme un aliase pour les routes parce que si il y a plusieurs id le routing se perdera
    #[ParamConverter("session", options:["mapping"=>["idSe"=>"id"]])]
    #[ParamConverter("module", options:["mapping"=>["idMo"=>"id"]])]
    
    public function removeModule(ManagerRegistry $doctrine, Session $session, int $idMo): Response
    {
        $em = $doctrine->getManager();
        $programmeRepository = $em->getRepository(Programme::class); // Assurez-vous d'importer correctement l'entité Programme
        $programme = $programmeRepository->find($idMo);
        
        // Assurez-vous que la méthode removeSessionProgramme attend un objet de type Programme
        $session->removeSessionProgramme($programme);
    
        $em->persist($session);
        $em->flush();
    
        return $this->redirectToRoute('app_showSession', ['id' => $session->getId()]);
    }
    


    #[Route("/session/removeStagiaire/{idSe}/{idSt}", name: 'removeStagiaire')]
    //ParamConverter sert un peu comme un aliase pour les routes parce que si il y a plusieurs id le routing se perdera
    #[ParamConverter("session", options:["mapping"=>["idSe"=>"id"]])]
    #[ParamConverter("stagiaire", options:["mapping"=>["idSt"=>"id"]])]
    
    public function removeStagiaire(ManagerRegistry $doctrine, Session $session, int $idSt): Response
    {
        $em = $doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->find($idSt);
        $session->removeSessionUser($user);
        $em->persist($session);
        $em->flush();

    return $this->redirectToRoute('app_showSession', ['id' => $session->getId()]);
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
