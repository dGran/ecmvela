<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Breed;
use App\Entity\Customer;
use App\Entity\Pet;
use App\Entity\PetCategory;
use App\Manager\PetCategoryManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PetType extends AbstractType
{
    public function __construct(private readonly PetCategoryManager $petCategoryManager)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $defaultCategory = $this->petCategoryManager->findOneById(PetCategory::TYPE_DOG_ID);
        $categoryData = $options['data']->getCategory() ?? $defaultCategory;

        $builder
            ->add('customer', EntityType::class, [
                'label' => 'Cliente (dueñ@)',
                'class' => Customer::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('customer')->orderBy('customer.name', 'ASC');
                },
                'placeholder' => 'Selecciona el cliente (dueñ@)',
            ])
            ->add('category', EntityType::class, [
                'label' => '*Categoría',
                'class' => PetCategory::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('category')->orderBy('category.name', 'ASC');
                },
                'placeholder' => 'Selecciona la categoría',
                'data' => $categoryData,
            ])
            ->add('breed', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('breed')->addOrderBy('breed.name', 'ASC');
                },
                'group_by' => function($breed) {
                    return $breed->getPetCategory()->getName();
                },
                'placeholder' => 'Selecciona raza',
            ])
            ->add('name', TextType::class, [
                'label' => '*Nombre',
                'attr' => [
                    'placeholder' => 'Nombre',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 1,
                        'minMessage' => 'El nombre de la mascota no puede estar vacío',
                    ]),
                ],
            ])
            ->add('color', TextType::class, [
                'attr' => [
                    'placeholder' => 'Color',
                ],
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'Cumpleaños',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                'label' => 'Foto perfil',
                'attr' => [
                    'accept' => "image/*",
                    'class' => 'block w-full text-sm text-slate-700 border border-slate-300 rounded focus:outline-none',
                ]
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
            'data_class' => Pet::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
