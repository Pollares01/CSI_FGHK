<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clEmail',TextType::class, [
                'label'=>'Email',
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Ex: katherine.stop@wanadoo.fr'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label'=>'Mot de passe',
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Ex: motdepasse'
                ]
            ])
            ->add('clNom', TextType::class, [
                'label'=>'Nom',
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Ex: Stop'
                ]
            ])
            ->add('clPrenom', TextType::class, [
                'label'=>'Prénom',
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Ex: Katherine'
                ]
            ])
            ->add('clDateDeNaiss', DateType::class, [
                'label'=>'Date de naissance',
                'widget'=>'single_text',
                'attr'=>[
                    'class' => 'form-control'
                ]
            ])
            ->add('clAdresse', TextType::class, [
                'label'=>'Adresse',
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Ex: 37 rue des pommes, CÉOUSSA'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
