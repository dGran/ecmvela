<?php

namespace App\Form;

use App\Entity\Dog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('breed')
            ->add('color')
            ->add('ownerName')
            ->add('ownerPhone')
            ->add('ownerEmail')
            ->add('ownerLocation')
            ->add('profileImg')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dog::class,
        ]);
    }
}
