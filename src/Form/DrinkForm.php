<?php

namespace App\Form;

use App\Entity\Drink;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DrinkForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('type', EntityType::class, [
                'class' => 'App\Entity\DrinkType',
                'choice_label' => 'name',
            ])
            ->add('containsAlcohol', CheckboxType::class, [
                'required' => false,
            ])
            ->add('price', MoneyType::class)
            ->add('bottleDepositPrice', MoneyType::class)
            ->add('package', ChoiceType::class, [
                'choices' => array_combine(Drink::PACKAGES, Drink::PACKAGES),
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'brand-color-bg text-white'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Drink::class,
        ]);
    }
}
