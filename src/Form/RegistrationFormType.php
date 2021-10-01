<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
    

            ->add('firstName',TextType::class, [
                'label' => 'Prénom',
                'required' => false
            ])

            ->add('lastName',TextType::class, [
                'label' => 'Nom',
                'required' => false
            ]) 

            ->add('email',EmailType::class, [
                'label' => 'Email',
                'required' => false
            ]) 

            ->add('telephone',TextType::class, [
                'label' => 'Téléphone',
            ])

            ->add('password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.',
                'mapped' => false,
                'required' => true,
                'label' => 'Mot de passe',
                'attr' => ['autocomplete' => 'new-password'],
                
                'first_options' =>[
                    'label' => 'Mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Vous devez entrer un mot de passe',
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Vous devez entrer une confirmation de votre mot de passe',
                        ]),
                    ],
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Veuillez accepter les CGUV',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Acceptez vous les conditions',
                    ]),
                ],
            ])
            ->add( 'submit', SubmitType::class, [
                'label' => "S'inscrire",
                'attr' => [

                ]
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
