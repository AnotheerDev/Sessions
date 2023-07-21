<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Session;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    #[Route('/formateur/{id}', name: 'app_formateur')]
    public function index(ManagerRegistry $doctrine, Formateur $formateur): Response
    {
        $sessions = $doctrine->getRepository(Session::class)->findAll();
        // dd($sessions);
        return $this->render('formateur/index.html.twig', [
            'formateur' => $formateur,
            'sessions' => $sessions,
        ]);
    }
}