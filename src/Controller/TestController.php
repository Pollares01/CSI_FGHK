<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        $faker = \Faker\Factory::create();
        $sql = '';


        for ($i=0; $i<20; $i++){
            $nomProduit = $faker->word;
            $descProduit = $faker->text(50);
            $list = array('Aliment', 'Electroménéger', 'Electronique','Culture','Jardin');
            $typeProduit = $list[array_rand($list, 1)];
            $sql .= 'insert into produit(prot_nom, prot_type, prot_description) VALUES (\''.$nomProduit.'\',\''.$typeProduit.'\',\''.$descProduit.'\');';
        }

        for ($i=0; $i<5; $i++){
            $ltPrixMin = $faker->randomDigit;
            $ltPrixEst = $faker->numberBetween($ltPrixMin, 20);
            $ltDateDeb = $faker->dateTimeBetween($startDate = '-30 days', $endDate = '+30 days');
            $ltDateFin = $faker->dateTimeBetween($startDate = $ltDateDeb, $endDate = $ltDateDeb->format("Y-m-d") . '+10 days');
            $ltStatut = 'En attente';
            $sql .= 'insert into Lot(lt_idlot, lt_prix_minimum, lt_prix_estime, lt_date_debut, lt_date_fin, lt_statut) values ('.$i.', '.$ltPrixMin.','.$ltPrixEst.',\''.$ltDateDeb->format("Y-m-d").'\',\''.$ltDateFin->format("Y-m-d").'\',\''.$ltStatut.'\');';

            for ($j=0; $j<rand(1, 7); $j++){
                $compProduit = rand(0,20);
                $compQte = rand(1,10);
                $sql .= 'insert into composition(comp_quantite, comp_idLot, comp_idProduit) VALUES ('.$compQte.', '.$i.','.$compProduit.');';
            }
        }

        return $this->render('test/index.html.twig', [
            'sql' => $sql,
        ]);
    }
}
