<?php

namespace App\Controller;

use App\Repository\PropositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte", name="compte")
     * @param PropositionRepository $propositionRepository
     * @return Response
     */
    public function index(PropositionRepository $propositionRepository): Response
    {

        $props = $propositionRepository->createQueryBuilder('p')
            ->where('p.propClient = :p')
            ->setParameter('p', $this->getUser())
            ->getQuery()
            ->getResult();


        return $this->render('compte/index.html.twig', [
            'props' => $props,
        ]);
    }
}
