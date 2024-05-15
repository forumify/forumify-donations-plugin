<?php

declare(strict_types=1);

namespace Forumify\Donations\Service;

use Forumify\Core\Repository\SettingRepository;
use Symfony\Component\Intl\Currencies;
use Symfony\Component\Intl\Exception\MissingResourceException;

class CurrencyFormatter
{
    public function __construct(private readonly SettingRepository $settingRepository)
    {
    }

    public function format(float $amount): string
    {
        $currency = $this->settingRepository->get('donations.currency') ?? 'USD';

        try {
            $symbol = Currencies::getSymbol($currency);
            $fractionDigits = Currencies::getFractionDigits($currency);
            return $symbol . ' ' . number_format($amount, $fractionDigits);
        } catch (MissingResourceException $ex) {
            return number_format($amount, 2);
        }
    }
}
