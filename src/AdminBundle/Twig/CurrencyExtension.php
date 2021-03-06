<?php

namespace App\AdminBundle\Twig;

use Symfony\Component\Intl\Intl;
use Twig_Extension;
use Twig_Filter;

class CurrencyExtension extends Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new Twig_Filter('currency_symbol', [$this, 'convertCurrencyCodeToSymbol']),
        ];
    }

    public function convertCurrencyCodeToSymbol($code)
    {
        return Intl::getCurrencyBundle()->getCurrencySymbol($code);
    }
}
