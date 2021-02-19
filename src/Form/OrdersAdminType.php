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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class OrdersAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          
            ->add('reference')
            ->add('customer', TextType::class,[
                'label' => 'Destinataire'
            ])
            ->add('user', EntityType::class, array(
                'class'=>User::class,
                'choice_label'=>'last_name', 
                'label'=>'Utilisateur'
               
            ))
            ->add('state', ChoiceType::class, [
                'choices' => [
                    'Non payée' => 0,
                'Payée' => 1,
                'Préparation en cours' => 2,
                'Prêt pour la collecte'=> 3,
                'Récupéré'=> 4
                
                ],
             'label'=>'Statut'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ]
            )
            ;

            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
