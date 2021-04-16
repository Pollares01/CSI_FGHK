<?php

namespace App\Controller;

use App\Repository\LotRepository;
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
     * @return Response
     */
    public function index(LotRepository $lotRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $lotRepository->createQueryBuilder('l')->getQuery();
        return $this->render('index/index.html.twig', [
            'lots'=> $paginator->paginate(
                $query,
                $request->query->get('page', 1),
                25
            )
        ]);
    }
}
