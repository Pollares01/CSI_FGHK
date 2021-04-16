<?php

namespace App\Controller;

use App\Entity\Proposition;
use App\Repository\LotRepository;
use App\Repository\ProduitRepository;
use App\Repository\PropositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{

    /**
     * @Route("/ajax/getListProduits", name="ajax_getListProduits")
     * @param Request $request
     * @param ProduitRepository $repository
     * @return JsonResponse|Response
     */
    public function getListProduits(Request $request, ProduitRepository $repository){
        if($request->isXmlHttpRequest()){
            $liste = $repository->findAll();
            $array = array();
            foreach ($liste as $produit){
                $array[$produit->getProtId()] = $produit->getProtNom();
            }
            return new JsonResponse($array);
        }
        return new Response('fail');
    }

    /**
     * @Route("/ajax/encherir", name="ajax_encherir")
     * @param Request $request
     * @param LotRepository $lotRepository
     * @param EntityManagerInterface $manager
     * @return JsonResponse|Response
     */
    public function encherir(Request $request, LotRepository $lotRepository, EntityManagerInterface $manager, PropositionRepository $propositionRepository){
        if($request->isXmlHttpRequest()){
            $id = $request->request->get('id');
            $prix = $request->request->get('prix');

            $lot = $lotRepository->find($id);
            try {
                $prop = $propositionRepository->createQueryBuilder('p')->where('p.propLot = :lot')
                    ->andWhere('p.propClient = :client')
                    ->setParameter(':lot', $lot)
                    ->setParameter(':client', $this->getUser())
                    ->getQuery()
                    ->getSingleResult();

                $prop->setPropPrix($prix);
//                $prop->setPropDate(new \DateTime());
//                $prop->setPropAccept(false);
                $prop->setPropNombre($prop->getPropNombre()+1);
                $manager->persist($prop);
                $manager->flush();
            } catch (NoResultException $e) {
                try {
                    if($prix >= $lot->getLtPrixMinimum()){
                        $prop = new Proposition();
                        $prop->setPropPrix($prix);
                        $prop->setPropClient($this->getUser());
                        $prop->setPropDate(new \DateTime());
                        $prop->setPropAccept(false);
                        $prop->setPropNombre(1);
                        $prop->setPropLot($lot);

                        $manager->persist($prop);
                        $manager->flush();
                    }
                } catch (\Exception $e){
                    return new Response('fail');
                }
            } catch (NonUniqueResultException $e) {
                return new Response('fail');
            }
            return new JsonResponse('ok');
        }
        return new Response('fail');
    }

}
