<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Orders;
use App\Entity\OrderDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class OrdersAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created_at', DateType::class, array(
                // отображает его как одно тестовое поле
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ))
            ->add('State')
            ->add('delivery_name')
            ->add('delivery_price', MoneyType::class)
            ->add('reference')
            ->add('customer')
            ->add('user', EntityType::class, array(
                'class'=>User::class,
                'choice_label'=>'last_name'
            ));
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
