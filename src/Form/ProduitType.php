<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('protNom', TextType::class, [
                'label'=>'Nom du produit',
                'attr'=>[
                    'placeholder'=> 'Ex: Pomme...',
                    'class'=>'form-control'
                ]
            ])
            ->add('protType', ChoiceType::class, [
                'label'=>'Type du produit',
                'choices'=>[
                    'Aliment' => 'Aliment',
                    'Electroménéger' => 'Electroménéger',
                    'Electronique' => 'Electronique',
                    'Culture' => 'Culture',
                    'Jardin' => 'Jardin',
                ],
                'placeholder'=> 'Veuillez sélectionner un type',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('protDescription', TextareaType::class, [
                'label'=>'Description du produit',
                'attr'=>[
                    'placeholder'=> 'Ex: Un fruit qui peut être cuisiné en tarte...',
                    'class'=>'form-control',
                    'rows'=>7
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
