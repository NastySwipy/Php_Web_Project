<?php

namespace SymfonyBlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productName', TextType::class)
            ->add('productType', ChoiceType::class, [
                'choices' => [
                    '-Select-' => null,
                    'Paraglider' => 'Paraglider',
                    'Paramotor' => 'Paramotor',
                    'Harness' => 'Harness',
                    'Parachute' => 'Parachute',
                    'Rucksack' => 'Rucksack',
                    'Speed Wing' => 'Speed Wing',
                    'Land Kite' => 'Land Kite',
                    'Snow Kite' => 'Snow Kite',
                    'Kite Surf' => 'Kite Surf',
                    'Clothing' => 'Clothing',
                    'Accessories' => 'Accessories',
                    'Merchandising' => 'Merchandising',
                    'Wingsuit' => 'Wingsuit',
                    'BASE Parachute' => 'BASE Parachute',
                ]
            ])
            ->add('make', TextType::class)
            ->add('model', TextType::class)
            ->add('productColor',TextType::class)
            ->add('productWeight', TextType::class)
            ->add('price', NumberType::class)
            ->add('quantity', NumberType::class)
            ->add('isNew')
            ->add('productLocationContinent', ChoiceType::class, [
                'choices' => [
                    '-Select-' => null,
                    'Asia' => 'Asia',
                    'Africa' => 'Africa',
                    'North America' => 'North America',
                    'South America' => 'South America',
                    'Antarctica' => 'Antarctica',
                    'Europe' => 'Europe',
                    'Oceania' => 'Oceania',
                ]
            ])
            ->add('productLocationCountry', TextType::class)
            ->add('productLocationCity', TextType::class)
            ->add('description', TextType::class)
            ->add('imageUrl', TextType::class);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SymfonyBlogBundle\Entity\Product'
        ));
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function getBlockPrefix()
//    {
//        return 'symfonyblogbundle_product';
//    }


}
