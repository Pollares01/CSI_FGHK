<?php

namespace App\Controller;

use App\Repository\LotRepository;
use App\Repository\PropositionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param LotRepository $lotRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(LotRepository $lotRepository, PaginatorInterface $paginator, Request $request, PropositionRepository $propositionRepository): Response
    {
        $query = $lotRepository->createQueryBuilder('l')
            ->where('l.ltStatut = \'En vente\'')->getQuery();

        $listProp = $propositionRepository->createQueryBuilder('p')
            ->where('p.propClient = :id')
            ->setParameter('id', $this->getUser())
            ->getQuery()
            ->getResult();


        $propositions = array();
        foreach ($listProp as $item) {
            $propositions[$item->getPropLot()->getLtIdLot()] = $item->getPropPrix();
        }


//        dd($propositions);
        return $this->render('index/index.html.twig', [
            'lots'=> $paginator->paginate(
                $query,
                $request->query->get('page', 1),
                25
            ),
            'propositions'=>$propositions
        ]);
    }
}
