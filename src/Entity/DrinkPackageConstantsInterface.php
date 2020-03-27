<?php

namespace App\Entity;

interface DrinkPackageConstantsInterface
{
    const PACKAGE_CAN = 'Can';
    const PACKAGE_GLASS = 'Glass';
    const PACKAGE_PLASTIC = 'Plastic';
    const PACKAGE_OTHERS = 'Others';

    const AVAILABLE_PACKAGES = [
        self::PACKAGE_CAN,
        self::PACKAGE_GLASS,
        self::PACKAGE_PLASTIC,
        self::PACKAGE_OTHERS
    ];
}


