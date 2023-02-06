<?php

namespace App\Form;

use App\Entity\Breed;
use App\Entity\Dog;
use App\Manager\BreedManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DogType extends AbstractType
{
    private BreedManager $breedManager;

    public function __construct(BreedManager $breedManager)
    {
        $this->breedManager = $breedManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nombre',
            ])
            ->add('breed', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'name'
            ])
            ->add('color')
            ->add('ownerName', null, [
                'label' => 'Nombre',
            ])
            ->add('ownerPhone', null, [
                'label' => 'Teléfono',
            ])
            ->add('ownerEmail', null, [
                'label' => 'Correo electrónico',
            ])
            ->add('ownerLocation', null, [
                'label' => 'Localidad',
            ])
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Foto perfil',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dog::class,
        ]);
    }
}