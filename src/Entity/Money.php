<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class Money
{
    /**
     * @var number
     * @Assert\Type("numeric")
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $amount;

    /**
     * @var string
     *
     * @Assert\Length(max=3)
     * @ORM\Column(length=3, options={"default": "EUR"})
     * @Assert\Currency
     */
    protected $currency = 'EUR';

    /**
     * Money constructor.
     * @param $amount
     * @param string $currency
     */
    public function __construct($amount, $currency = 'EUR')
    {
        $this->setAmount($amount);
        $this->setCurrency($currency);
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return is_null($this->amount) ? null : (float)$this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        if ($amount === '') {
            $amount = null;
        }

        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return !is_null($this->amount) ? number_format($this->amount, 2) . ' ' . $this->currency : '';
    }

    /**
     * @param string $value
     * @return Money
     */
    public static function createFromString(string $value): Money
    {
        $parts = explode(' ', $value, 2);

        if (count($parts) === 2) {
            list($amount, $currency) = $parts;
        } else {
            $currency = null;
            $amount = (string)$value;
        }

        $amount = trim(str_replace(',', '', $amount));

        if ($amount === '') {
            $amount = null;
        }

        $money = new Money($amount);

        if ($currency) {
            $money->setCurrency($currency);
        }

        return $money;
    }

    /**
     * @param Money|string $value
     * @return Money
     */
    public static function convertToMoney($value): Money
    {
        if (!$value instanceof Money) {
            $value = self::createFromString($value);
        }

        return $value;
    }
}
