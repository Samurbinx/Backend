<?php

namespace App\Form;

use App\Entity\Artwork;
use App\Entity\Work;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Title', TextType::class, [
            'label' => 'Título',
            'required' => false,
        ])
        ->add('Creation_date', DateType::class, [
            'label' => 'Año de creación',
            'widget' => 'single_text',
            'required' => false,
        ])
        ->add('Price', NumberType::class, [
            'label' => 'Precio',
            'required' => false,
            'constraints' => [
                new GreaterThanOrEqual([
                    'value' => 0,
                    'message' => 'El precio no puede ser negativo.',
                ]),
            ],
        ])
        ->add('Sold', CheckboxType::class, [
            'label' => 'Vendido',
            'required' => false
        ])
        ->add('Display', ChoiceType::class, [
            'label' => 'Mostrar',
            'choices' => [
                'Simple' => "simple",
                'Díptico' => "diptych",
                'Carrusel de portada' => "covercarousel",
                'Carrusel de detalle' => "detail",
            ],
            'required' => true,
            'placeholder' => 'Selecciona una opción', // Opción por defecto
        ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
