<?php

namespace App\Controller;

use App\Entity\Saison;
use App\Form\SaisonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaisonController extends AbstractController
{
    #[Route('/saison', name: 'app_saison')]
    public function index(
        EntityManagerInterface $entityManager,
        Request                $request
    ): Response
    {
        $saison = new Saison();
        $formSaison = $this->createForm(SaisonType::class, $saison);
        $formSaison->handleRequest($request);
        if ($formSaison->isSubmitted() && $formSaison->isValid()) {
            $entityManager->persist($saison);
            $entityManager->flush();
            $this->addFlash('success', 'Saison ajoutée');
            return $this->redirectToRoute('app_saison');
        }
        return $this->render(
            'saison/index.html.twig',
            compact('formSaison')
        );
    }
}
