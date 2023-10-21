<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Pet;
use App\Entity\Sale;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', EntityType::class, [
                'label' => 'Cliente',
                'class' => Customer::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('customer')->orderBy('customer.name', 'ASC');
                },
                'placeholder' => 'Selecciona el cliente',
            ])
            ->add('pet', EntityType::class, [
                'label' => 'Mascota',
                'class' => Pet::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('pet')->orderBy('petº.name', 'ASC');
                },
                'placeholder' => 'Selecciona la mascota',
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Observaciones',
                'attr' => [
                    'placeholder' => 'Notas o comentarios',
                    'rows' => 5
                ],
            ])
            ->add('maintenancePlan', CheckboxType::class, [
                'label' => 'Plan de mantenimiento',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sale::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
