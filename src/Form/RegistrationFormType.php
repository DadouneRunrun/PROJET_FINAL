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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
    

            ->add('firstName',TextType::class, [
                'label' => 'Prénom',
                'attr' =>[
                    'placeholder' => 'Entrez votre prénom'
                ]
            ])

            ->add('lastName',TextType::class, [
                'label' => 'Nom',
                'attr' =>[
                    'placeholder' => 'Entrez votre nom'
                ]
            ]) 

            ->add('email',EmailType::class, [
                'label' => 'Email',
                'attr' =>[
                    'placeholder' => 'Entrez votre email'
                ]
            ]) 

            ->add('telephone',TextType::class, [
                'label' => 'Téléphone',
                'attr' =>[
                    'placeholder' => 'Entrez votre numéro de téléphone'
                ]
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Mot de passe',
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir {{ limit }} caractères minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Veuillez accepter les conditions d\'utilisation',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Acceptez vous les conditions',
                    ]),
                ],
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
