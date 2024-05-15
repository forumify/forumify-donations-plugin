<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\Form;

use Forumify\Core\Form\RichTextEditorType;
use Forumify\Core\Repository\SettingRepository;
use Forumify\Donations\Entity\DonationGoal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonationGoalType extends AbstractType
{
    public function __construct(private readonly SettingRepository $settingRepository)
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DonationGoal::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $paypalButtonIdRequired = $this->settingRepository->get('donations.paypal_button_id') === null;

        $builder
            ->add('title', TextType::class)
            ->add('description', RichTextEditorType::class, [
                'required' => false,
                'empty_data' => '',
            ])
            ->add('goal', NumberType::class)
            ->add('closeWhenReached', CheckboxType::class, [
                'required' => false,
                'help' => 'Stop accepting donations once the goal is reached.',
            ])
            ->add('from', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('to', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('paypalButtonId', TextType::class, [
                'required' => $paypalButtonIdRequired,
                'empty_data' => null,
                'help' => 'Override the global button ID. Can be left blank if a global button is configured.',
            ]);
    }
}
