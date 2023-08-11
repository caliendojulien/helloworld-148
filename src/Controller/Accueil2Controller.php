<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Accueil2Controller extends AbstractController
{
    #[Route('/', name: 'accueil2_index')]
    public function index(): Response
    {
        $nombre = 42;
        $hasard = rand(0, 1);
        $titre = "<script>alert('coucou')</script>";

        return $this->render(
            'accueil2/index.html.twig',
            [
                "nombre" => $nombre,
                "hasard" => $hasard,
                "titre" => $titre,
            ]
        );
        return $this->render(
            'accueil2/index.html.twig',
            compact('nombre', 'hasard')
        );
    }

    #[Route('/accueil123', name: 'accueil2_index123')]
    public function index123(): Response
    {
        return $this->render('accueil2/index123.html.twig', [
            'controller_name' => 'Accueil2Controller',
        ]);
    }
}
