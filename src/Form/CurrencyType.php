<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\CurrencyType as CoreCurrencyType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CurrencyType extends CoreCurrencyType
{
    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'preferred_choices' => ['EUR'],
            'choice_label' => function ($value) {
                return $value;
            },
        ]);
    }
}
