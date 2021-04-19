<?php

namespace App\Controller;

use App\Repository\LotRepository;
use App\Repository\ProduitRepository;
use App\Repository\PropositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param LotRepository $lotRepository
     * @param ProduitRepository $produitRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param PropositionRepository $propositionRepository
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request ,LotRepository $lotRepository, ProduitRepository $produitRepository,PaginatorInterface $paginator, PropositionRepository $propositionRepository, EntityManagerInterface $manager): Response
    {
        LotController::majLot($lotRepository, $manager, $propositionRepository);

        $form = $this->createFormBuilder();
        $products = $produitRepository->findAll();

        $produitChoix = array();
        foreach ($products as $produit) {
            $produitChoix[$produit->getProtNom()] = $produit->getProtId();
        }

        $form->add('produits', ChoiceType::class, [
            'choices'=>$produitChoix,
            'multiple'=>true,
            'attr'=>[
                'class'=>'select-produit form-control'
            ]
        ]);

        $form = $form->getForm();
        $query = $lotRepository->createQueryBuilder('l')
            ->where('l.ltStatut = \'En vente\'');
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if($form->isValid()){
                if(!empty($form->getViewData()['produits'])){
                    $query->join('l.composition', 'c')
                    ->andWhere('c.compIdproduit in (:array)')
                    ->setParameter('array', $form->getViewData()['produits']);
                }
            }
        }



        $query = $query->getQuery();

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
            'propositions'=>$propositions,
            'form'=>$form->createView()
        ]);
    }
}
