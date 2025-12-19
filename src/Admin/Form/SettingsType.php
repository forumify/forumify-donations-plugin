<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Currencies;

/**
 * @extends AbstractType<array<string, mixed>>
 */
class SettingsType extends AbstractType
{
    private const SUPPORTED_CURRENCIES = [
        'USD',
        'EUR',
        'GBP',
        'CAD',
        'AUD',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('donations__currency', ChoiceType::class, [
                'label' => 'Currency',
                'help' => 'Currency to show all transactions in. This must match the currency on your buttons. No currency conversion will be done on forumify!',
                'choices' => $this->getCurrencyOptions(),
            ])
            ->add('donations__paypal_button_id', TextType::class, [
                'label' => 'Global PayPal Button ID',
                'required' => false,
                'attr' => [
                    'placeholder' => 'YZP8P67Q54DF',
                ],
                'help' => 'Create/find your donate button <a href="https://www.paypal.com/donate/buttons" target="_blank">here</a>, and copy its ID. Buttons can also be overridden on donation goals.',
                'help_html' => true,
            ])
            ->add('donations__paypal_dev_mode', CheckboxType::class, [
                'label' => 'Enable PayPal dev mode',
                'help' => 'Enable dev mode to use buttons from PayPal sandbox.',
                'required' => false,
            ]);
    }

    /**
     * @return array<string, string>
     */
    private function getCurrencyOptions(): array
    {
        $choices = [];
        foreach ($this::SUPPORTED_CURRENCIES as $currency) {
            $choices[Currencies::getName($currency)] = $currency;
        }

        return $choices;
    }
}
