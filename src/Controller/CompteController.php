<?php

namespace App\Controller;

use App\Repository\LotRepository;
use App\Repository\PropositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte", name="compte")
     * @param PropositionRepository $propositionRepository
     * @param LotRepository $lotRepository
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(PropositionRepository $propositionRepository, LotRepository $lotRepository, EntityManagerInterface $manager): Response
    {
        LotController::majLot($lotRepository, $manager, $propositionRepository);
        $props = $propositionRepository->createQueryBuilder('p')
            ->where('p.propClient = :p')
            ->setParameter('p', $this->getUser())
            ->getQuery()
            ->getResult();

        $gagnants = array();
        $propositions = array();
        foreach ($props as $prop) {
            $propositions[$prop->getPropLot()->getLtIdLot()] = $prop->getPropPrix();

            $propLot = $propositionRepository->createQueryBuilder('p')
                ->where('p.propLot = :lot')
                ->setParameter('lot', $prop->getPropLot())
                ->getQuery()
                ->getResult();
            foreach ($propLot as $pl) {
                if($pl->getPropAccept()==true){
                    $gagnants[$prop->getPropLot()->getLtIdLot()]= $pl->getPropClient()->getClNom() . ' ' .$pl->getPropClient()->getClPrenom();
                }
            }

//            try {
//                $searchGagnant = $propositionRepository->createQueryBuilder('p')
//                    ->where('p.propAccept = true')
//                    ->andWhere('p.propId = :pid')
//                    ->setParameter('pid', $prop->getPropId())
//                    ->getQuery()
//                    ->getSingleResult();
//
//                dump($searchGagnant);
//                $gagnants[$prop->getPropLot()->getLtIdLot()]=$searchGagnant->getPropClient()->getClNom() . ' ' . $searchGagnant->getPropClient()->getClPrenom();
//            } catch (NoResultException | NonUniqueResultException $e) {
//            }
        }



        return $this->render('compte/index.html.twig', [
            'props' => $props,
            'propositions'=> $propositions,
            'gagnants'=>$gagnants
        ]);
    }
}
