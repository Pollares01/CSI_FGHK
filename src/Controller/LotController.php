<?php

namespace App\Controller;

use App\Entity\Lot;
use App\Form\LotType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LotController extends AbstractController
{
    /**
     * @Route("/lot", name="lot")
     */
    public function index(): Response
    {
        return $this->render('lot/index.html.twig', [
            'controller_name' => 'LotController',
        ]);
    }


    /**
     * @Route("/admin/lot/mod/new", name="lot_new")
     * @Route("/admin/lot/mod/{id}", name="lot_edit")
     * @param Lot|null $lot
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function mod(Lot $lot = null, EntityManagerInterface $manager, Request $request){
        if(!$lot){
            $lot = new Lot();
        }

        $form = $this->createForm(LotType::class, $lot);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            if ($form->isValid()){
                $manager->persist($lot);
                $manager->flush();

                return $this->redirectToRoute('lot');
            }
        }
        return $this->render('lot/mod.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
