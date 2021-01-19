<?php

namespace App\Form;


use App\Entity\Category;
use App\Entity\ItemMenu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ItemMenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('category', EntityType::class, array(
                'class'=>Category::class,
                'choice_label'=>'name',
            ) 
                
            )
            ->add('ingredients', TextareaType::class)
            ->add('price', MoneyType::class)
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
            'data_class' => ItemMenu::class,
        ]);
    }
}

