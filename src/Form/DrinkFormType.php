<?php

namespace App\Form;

use App\Entity\Drink;
use App\Entity\DrinkPackageConstantsInterface;
use App\Entity\DrinkType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DrinkFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type', EntityType::class, [
                'class' => DrinkType::class,
                'label' => 'Choose drink type',
                'choice_label' => 'name'
            ])
            ->add('containsAlcohol', CheckboxType::class, [
                'required' => false
            ])
            ->add('price', MoneyType::class)
            ->add('bottleDepositPrice', MoneyType::class)
            ->add('package', ChoiceType::class, [
                'choices' => DrinkPackageConstantsInterface::AVAILABLE_PACKAGES,
                'label' => 'Choose a package'
            ])
            ->add('Save', SubmitType::class, [
                'attr' => ['class' => 'btn-success btn-block']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Drink::class,
        ]);
    }
}
