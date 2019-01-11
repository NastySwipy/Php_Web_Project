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
            ->add('make', TextType::class)
            ->add('model', TextType::class)
            ->add('price', NumberType::class)
            ->add('quantity', NumberType::class)
            ->add('isNew')
            ->add('productLocationContinent', ChoiceType::class,[
                'choices' =>[
                    'Select Continent' => null,
                    'Asia' => 'Asia',
                    'Africa'=> 'Africa',
                    'North America'=> 'North America',
                    'South America'=> 'South America',
                    'Antarctica'=> 'Antarctica',
                    'Europe'=> 'Europe',
                    'Oceania'=> 'Oceania',
                ]
            ])
            ->add('productLocationCountry')
            ->add('description')
            ->add('imageUrl');
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
