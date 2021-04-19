<?php

namespace App\Controller;

use App\Entity\Composition;
use App\Entity\Lot;
use App\Repository\LotRepository;
use App\Repository\ProduitRepository;
use App\Repository\PropositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LotController extends AbstractController
{


    public static function majLot(LotRepository $lotRepository, EntityManagerInterface $manager, PropositionRepository $propositionRepository){
        $lotFuturs = $lotEnAttente = $lotRepository->createQueryBuilder('l')
            ->where('l.ltDateDebut > :date')
//            ->andWhere('l.ltDateFin < :date')
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getResult();
//        dump($lotFuturs);
        foreach ($lotFuturs as $lot) {
            $lot->setLtStatut("En attente");

            $manager->persist($lot);
        }
//        dd(new \DateTime());

        $lotEnAttente = $lotRepository->createQueryBuilder('l')
            ->where('l.ltDateDebut < :date')
            ->andWhere('l.ltDateFin > :date')
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getResult();

        foreach ($lotEnAttente as $lot) {
            $lot->setLtStatut("En vente");

            $manager->persist($lot);
        }

        $lotATerminer = $lotRepository->createQueryBuilder('l')
            ->where('l.ltDateFin < :date')
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getResult();

        foreach ($lotATerminer as $lot) {
            if($lot->getLtStatut() != "Terminé"){
                $lot->setLtStatut("Terminé");

                $propositions = $propositionRepository->createQueryBuilder('p')
                    ->where('p.propLot = :l')
                    ->andWhere()
                    ->setParameter('l', $lot)
                    ->getQuery()
//                ->getDQL();
                    ->getResult();


                $prixMax = $lot->getLtPrixMinimum();
                $propTemp = null;
                foreach ($propositions as $pro) {
                    if($pro->getPropPrix() > $prixMax){
                        if($propTemp != null) {
                            $propTemp->setPropAccept(false);
                        }
                        $pro->setPropAccept(true);
                        $prixMax = $pro->getPropPrix();
                        $propTemp = $pro;
                    } else if($pro->getPropPrix() == $prixMax){
                        if($propTemp != null) {
                            if($propTemp->getPropDate() < $pro->getPropDate()){
                                $propTemp->setPropAccept(false);
                                $pro->setPropAccept(true);
                                $prixMax = $pro->getPropPrix();
                                $propTemp = $pro;
                            }
                        } else{
                            $pro->setPropAccept(true);
                            $prixMax = $pro->getPropPrix();
                            $propTemp = $pro;
                        }
                    }
                    if($propTemp != null) {
                        $manager->persist($propTemp);
                    }
                    $manager->persist($pro);
                }
            }

            $manager->persist($lot);
        }
        $manager->flush();
    }


    /**
     * @Route("/lot", name="lot")
     * @param LotRepository $lotRepository
     * @return Response
     */
    public function index(LotRepository $lotRepository, EntityManagerInterface $manager, PropositionRepository $propositionRepository): Response
    {
        LotController::majLot($lotRepository, $manager, $propositionRepository);
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
    public function mod(Lot $lot = null, EntityManagerInterface $manager, Request $request, ProduitRepository $produitRepository, LotRepository $lem){
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
            ]);
//            ->add('ltStatut', ChoiceType::class, [
//                'label'=>'Statut du lot',
//                'choices'=>[
//                    'En vente' => 'En vente',
//                    'En attente' => 'En attente',
//                ],
//                'placeholder'=> 'Veuillez sélectionner un statut',
//                'attr'=>[
//                    'class'=>'form-control'
//                ]
//            ]);

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

                $id = ($lem->createQueryBuilder('l')->select('max(l.ltIdlot)')->getQuery()->getSingleScalarResult())+1;


                $lot->setLtIdlot($id);
                $lot->setLtDateDebut($form->getViewData()['ltDateDebut']);
                $lot->setLtDateFin($form->getViewData()['ltDateFin']);
                $lot->setLtStatut('En attente');
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
