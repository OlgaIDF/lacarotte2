<?php

namespace App\Form;

use App\Entity\Actus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ActuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', TextType::class )
            ->add('Content', TextType::class )
            ->add('created_at', DateType::class, array(
                // отображает его как одно тестовое поле
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ))
            ->add('img', FileType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Image'
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
            'data_class' => Actus::class,
        ]);
    }
}
