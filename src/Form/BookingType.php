<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Customer;
use App\Entity\Pet;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $durations = [];
        for ($i = 15; $i <= 240; $i += 15) {
            if ($i < 60) {
                $durations[$i . ' minutos'] = $i;
            } elseif ($i === 60) {
                $durations['1 hora'] = $i;
            } else {
                $hours = floor($i / 60);
                $minutes = $i % 60;

                $label = $hours . ' hora';
                if ($hours > 1) {
                    $label .= 's';
                }
                if ($minutes > 0) {
                    $label .= ' y ' . $minutes . ' minutos';
                }

                $durations[$label] = $i;
            }
        }

        $builder
            ->add('date', DateTimeType::class, [
                'label' => 'Fecha',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => '01/01/2024',
                    'class' => 'w-full px-3 py-1.5 text-sm font-normal text-slate-700 bg-slate-50 border-solid border-slate-300 rounded transition ease-in-out m-0 focus:text-slate-700 focus:bg-white focus:border-blue-400 focus:outline-none',
                ],
            ])
            ->add('pet', EntityType::class, [
                'label' => 'Mascota',
                'class' => Pet::class,
                'choice_label' => function (Pet $pet) {
                    $customerName = $pet->getCustomer() ? $pet->getCustomer()->getName() : 'Sin dueño';
                    return sprintf('%s (%s)', $pet->getName(), $customerName);
                },
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('pet')->orderBy('pet.name', 'ASC');
                },
                'placeholder' => 'Selecciona la mascota',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => function($customer) {
                    $petNames = $customer->getPets()->map(function ($pet) {
                        return $pet->getName();
                    })->toArray();
                    $petNamesString = implode(', ', $petNames);
                    return $customer->getName().' ('.$petNamesString. ')';
                },
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('customer')->orderBy('customer.name', 'ASC');
                },
                'placeholder' => 'Selecciona el cliente (dueñ@)',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('estimatedDuration', ChoiceType::class, [
                'label' => 'Duración estimada',
                'choices' => $durations,
                'placeholder' => 'Selecciona la duración estimada',
            ])
            ->add('estimatedPrice', NumberType::class, [
                'label' => 'Precio estimado',
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'placeholder' => 'Introduzca el precio estimado',
                    'step' => '0.5'
//                    'pattern'   => '[0-9]+'
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
            'data_class' => Booking::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
