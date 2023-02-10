<?php

namespace App\Form;

use App\Entity\Breed;
use App\Entity\Dog;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => [
                    'placeholder' => 'Nombre del perro',
                ],
                'required' => true,
            ])
            ->add('breed', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('breed')->orderBy('breed.dogSize', 'ASC')->addOrderBy('breed.name', 'ASC');
                },
                'group_by' => function($breed) {
                    return $breed->getDogSize()->getName();
                },
                'placeholder' => 'Selecciona raza',
                'required' => false,
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Cumpleaños',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false,
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Observaciones',
                'attr' => [
                    'placeholder' => 'Notas o comentarios sobre el perro',
                    'rows' => 5
                ],
                'required' => false,
            ])
            ->add('color', TextType::class, [
                'attr' => [
                    'placeholder' => 'Color del perro',
                ],
                'required' => false,
            ])
            ->add('ownerName', TextType::class, [
                'label' => 'Nombre',
                'attr' => [
                    'placeholder' => 'Nombre del dueño',
                ],
                'required' => true,
            ])
            ->add('ownerPhone', TelType::class, [
                'label' => 'Teléfono',
                'attr' => [
                    'placeholder' => 'Teléfono del dueño',
                ],
                'required' => false,
            ])
            ->add('ownerEmail', EmailType::class, [
                'label' => 'Correo electrónico',
                'attr' => [
                    'placeholder' => 'Correo electrónico',
                ],
                'required' => false,
            ])
            ->add('ownerAddress', TextType::class, [
                'label' => 'Dirección',
                'attr' => [
                    'placeholder' => 'Dirección de facturación',
                ],
                'required' => false,
            ])
            ->add('ownerLocation', TextType::class, [
                'label' => 'Localidad',
                'attr' => [
                    'placeholder' => 'Localidad de facturación',
                ],
                'required' => false,
            ])
            ->add('ownerIdentification', TextType::class, [
                'label' => 'Número de identificación',
                'attr' => [
                    'placeholder' => 'DNI / NIE',
                ],
                'required' => false,
            ])
            ->add('ownerCP', TextType::class, [
                'label' => 'Código Postal',
                'attr' => [
                    'placeholder' => 'Código postal de facturación',
                ],
                'required' => false,
            ])

            ->add('active', CheckboxType::class, [
                'label' => 'Activo',
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