<?php

namespace App\Form;

use App\Entity\Drink;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DrinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => function(Type $type) {
                    return sprintf('(%d) %s', $type->getId(), $type->getName());
                },
                'placeholder' => 'Choose a type',
            ])
            ->add('contains_alcohol')
            ->add('price')
            ->add('bottle_deposit_price')
            ->add('package')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Drink::class,
        ]);
    }
}
