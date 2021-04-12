<?php

namespace App\Form;

use App\Entity\Lot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ltPrixMinimum', IntegerType::class, [
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
            ])
            ->add('nbTypeArt', HiddenType::class, [
                'attr'=>[
                    'value'=>0
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lot::class,
        ]);
    }
}
