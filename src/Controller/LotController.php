<?php

namespace App\Controller;

use App\Entity\Composition;
use App\Entity\Lot;
use App\Entity\Produit;
use App\Form\LotType;
use App\Repository\LotRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LotController extends AbstractController
{
    /**
     * @Route("/lot", name="lot")
     * @param LotRepository $lotRepository
     * @return Response
     */
    public function index(LotRepository $lotRepository): Response
    {

        return $this->render('lot/index.html.twig', [
            'listLot' => $lotRepository->findAll(),
        ]);
    }


    /**
     * @Route("/admin/lot/mod/new", name="lot_new")
     * @Route("/admin/lot/mod/{id}", name="lot_edit")
     * @param Lot|null $lot
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param ProduitRepository $produitRepository
     * @return RedirectResponse|Response
     */
    public function mod(Lot $lot = null, EntityManagerInterface $manager, Request $request, ProduitRepository $produitRepository){
        if(!$lot){
            $lot = new Lot();
        }
        $form = $this->createFormBuilder();

        $form->add('ltPrixMinimum', IntegerType::class, [
            'label'=>'Prix minimum du produit',
            'attr' => [
                'class'=>'form-control',
                'min'=>0
            ]
        ])
            ->add('ltPrixEstime', IntegerType::class, [
                'label'=>'Prix estimé du produit',
                'attr' => [
                    'class'=>'form-control'
                ]
            ])
            ->add('ltDateDebut', DateType::class, [
                'label'=>'Date de début de vente du lot',
                'widget'=>'single_text',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('ltDateFin', DateType::class, [
                'label'=>'Date de fin de vente du lot',
                'widget'=>'single_text',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('ltStatut', ChoiceType::class, [
                'label'=>'Statut du lot',
                'choices'=>[
                    'En vente' => 'En vente',
                    'En attente' => 'En attente',
                ],
                'placeholder'=> 'Veuillez sélectionner un statut',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ]);

        $listProd = $produitRepository->findAll();
        foreach ($listProd as $produit) {
            $form->add('lotProduitNb'.$produit->getProtId(),IntegerType::class, [
                'label'=>' ',
                'attr' => [
                    'class'=>'form-control',
                    'value'=>0,
                    'min'=>0
                ]
            ]);
        }


        $form = $form->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if ($form->isValid()){

                $lot->setLtDateDebut($form->getViewData()['ltDateDebut']);
                $lot->setLtDateFin($form->getViewData()['ltDateFin']);
                $lot->setLtStatut($form->getViewData()['ltStatut']);
                $lot->setLtPrixEstime($form->getViewData()['ltPrixEstime']);
                $lot->setLtPrixMinimum($form->getViewData()['ltPrixMinimum']);

                $manager->persist($lot);
                foreach ($listProd as $produit) {
                    if ($form->getViewData()['lotProduitNb'.$produit->getProtId()]!=0){
                        $comp = new Composition();
                        $comp->setCompIdlot($lot);
                        $comp->setCompIdproduit($produit);
                        $comp->setCompQuantite($form->getViewData()['lotProduitNb'.$produit->getProtId()]);
                        $manager->persist($comp);
                    }

                }

                $manager->flush();

                return $this->redirectToRoute('lot');
            }
        }
        return $this->render('lot/mod.html.twig', [
            'form'=>$form->createView(),
            'listProd'=>$listProd
        ]);
    }
}
