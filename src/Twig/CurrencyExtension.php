<?php

declare(strict_types=1);

namespace Forumify\Donations\Twig;

use Forumify\Donations\Service\CurrencyFormatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CurrencyExtension extends AbstractExtension
{
    public function __construct(private readonly CurrencyFormatter $currencyFormatter)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('currency', $this->currencyFormatter->format(...)),
        ];
    }
}
