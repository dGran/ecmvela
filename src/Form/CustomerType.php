<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => '*Nombre',
                'attr' => [
                    'placeholder' => 'Nombre',
                    'autofocus' => true,
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Teléfono',
                'attr' => [
                    'placeholder' => '(+34) xxx xxx xxx',
                ],
            ])
            ->add('phone2', TelType::class, [
                'label' => 'Teléfono 2',
                'attr' => [
                    'placeholder' => '(+34) xxx xxx xxx',
                ],
            ])
            ->add('phone3', TelType::class, [
                'label' => 'Teléfono 3',
                'attr' => [
                    'placeholder' => '(+34) xxx xxx xxx',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico',
                'attr' => [
                    'placeholder' => 'example@example.com',
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Dirección',
                'attr' => [
                    'placeholder' => 'Dirección del cliente',
                ],
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Código Postal',
                'attr' => [
                    'placeholder' => 'Ej: 46530',
                ],
            ])
            ->add('location', TextType::class, [
                'label' => 'Localidad',
                'attr' => [
                    'placeholder' => 'Ej: Puzol',
                ],
            ])
            ->add('province', TextType::class, [
                'label' => 'Provincia',
                'attr' => [
                    'placeholder' => 'Ej: Valencia',
                ],
            ])
            ->add('identification', TextType::class, [
                'label' => 'Número de identificación',
                'attr' => [
                    'placeholder' => 'DNI / NIE',
                ],
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Observaciones',
                'attr' => [
                    'placeholder' => 'Notas o comentarios',
                    'rows' => 5
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
