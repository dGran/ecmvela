<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\PublicHoliday;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicHolidayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Fecha',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => '01/01/2024',
                    'class' => 'w-full px-3 py-1.5 text-sm font-normal text-slate-700 bg-slate-50 border-solid border-slate-300 rounded transition ease-in-out m-0 focus:text-slate-700 focus:bg-white focus:border-blue-400 focus:outline-none',
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => [
                    'placeholder' => 'Nombre',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PublicHoliday::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
