<?php

namespace App\Form;

use App\Entity\Orders;
use App\Entity\Customer;
use App\Entity\Delivery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];

        $builder
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                'label' => false,
                'choices' => $user->getCustomers(),
                'required' => true,
                'multiple' => false,
                'expanded' => true
            ])
            ->add('delivery', EntityType::class, [
                'class' => Delivery::class,
                'label' => 'Choisir un transporteur',
                'required' => true,
                'multiple' => false,
                'expanded' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => "btn btn-lg text-center my-3 btn-block"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => array()
        ]);
    }
}

