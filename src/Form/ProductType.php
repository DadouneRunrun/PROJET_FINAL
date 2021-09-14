<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'label' => 'Nom',
                'attr' =>[
                    'placeholder' => 'Entrez le nom du produit'
                ]
            ])
            ->add('price',TextType::class, [
                'label' => 'Prix',
                'attr' =>[
                    'placeholder' => 'Entrez le prix du produit'
                ]
            ])
            ->add('picture')
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
