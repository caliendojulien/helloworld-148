<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog', name: 'serie')]
class SerieController extends AbstractController
{
    #[Route('/series', name: '_liste')]
    public function liste(
        SerieRepository $serieRepository
    ): Response
    {
        $series = $serieRepository->findAll();
        return $this->render(
            'serie/liste.html.twig',
            compact('series')
        );
    }





    #[Route('/creation', name: '_creation')]
    public function creation(
        EntityManagerInterface $entityManager,
        Request $requete
    ): Response
    {
        $serie = new Serie();
        $serieForm = $this->createForm(SerieType::class, $serie);

        $serieForm->handleRequest($requete);

        if($serieForm->isSubmitted() && $serieForm->isValid()) {
            $entityManager->persist($serie);
            $entityManager->flush();
            $this->addFlash('success', 'Série ajoutée');
            return $this->redirectToRoute('serie_liste');
        }

        return $this->render(
            'serie/creation.html.twig',
            [
                "serieForm" => $serieForm->createView()
            ]
        );
    }







    #[Route(
        '/serie/{serie}',
        name: '_detail',
        requirements: ["serie" => "\d+"])]
    public function detail(
//        SerieRepository $serieRepository,
        Serie $serie
    ): Response
    {
//        $serie = $serieRepository->findOneBy(
//            ["id" => $id]
//        );
        return $this->render(
            'serie/detail.html.twig',
            compact('serie')
        );
    }
}
