<?php

namespace App\Controller;

use App\Entity\Formation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $formations = $doctrine->getRepository( Formation::class)->findBy([], ["name" => "ASC"]);
        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }
}