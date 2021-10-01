<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon adresse email'
            ])
            ->add('firstName', TextType::class, [
                'disabled' => true,
                'label' => 'Mon prénom'
            ])
            ->add('lastName', TextType::class, [
                'disabled' => true,
                'label' => 'Mon nom'
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.',
                'mapped' => false,
                'required' => true,
                'label' => 'Votre nouveau mot de passe',
                'attr' => ['autocomplete' => 'new-password'],
                
                'first_options' =>[
                    'label' => 'Mon nouveau mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Vous devez entrer un mot de passe',
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer votre nouveau mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Vous devez entrer une confirmation de votre nouveau mot de passe',
                        ]),
                    ]
                ],
            ])
            ->add( 'submit', SubmitType::class, [
                'label' => "Mettre à jour"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
