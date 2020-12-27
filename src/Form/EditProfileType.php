<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                     
            ->add('last_name', TextType::class)
            ->add('first_name', TextType::class)
            ->add('email', EmailType::class) 
            ->add('phone', TextType::class)
            
            ->add('Valider', SubmitType::class, [
                'attr' => [
                   'class'=>"btn btn-lg text-center mt-3 ml-3 float-right profile_btn" 
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
