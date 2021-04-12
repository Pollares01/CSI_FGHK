<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $repository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/produit/mod/new", name="produit_new")
     * @Route("/admin/produit/mod/{id}", name="produit_edit")
     * @param Produit|null $produit
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return string|RedirectResponse
     */
    public function mod(Produit $produit = null, EntityManagerInterface $manager, Request $request){
        if(!$produit){
            $produit = new Produit();
        }

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if ($form->isValid()){
                $manager->persist($produit);
                $manager->flush();

                return $this->redirectToRoute('produit');
            }
        }
        return $this->render('produit/mod.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
