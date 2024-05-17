<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\Form;

use Forumify\Core\Entity\User;
use Forumify\Donations\Entity\Donation;
use Forumify\Donations\Entity\DonationGoal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonationType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('transactionId', TextType::class, [
                'required' => false,
                'help' => 'Transaction ID from PayPal. This field is optional in case you want to record outside donations.'
            ])
            ->add('amount')
            ->add('user', EntityType::class, [
                'autocomplete' => true,
                'placeholder' => '',
                'required' => false,
                'class' => User::class,
                'choice_label' => 'username',
            ])
            ->add('goal', EntityType::class, [
                'autocomplete' => true,
                'placeholder' => '',
                'required' => false,
                'class' => DonationGoal::class,
                'choice_label' => 'title',
            ]);
    }
}
