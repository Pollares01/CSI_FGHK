<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
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

}
