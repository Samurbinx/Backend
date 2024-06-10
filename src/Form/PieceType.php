<?php

namespace App\Form;

use App\Entity\Piece;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PieceType extends AbstractType
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
            ->add('Materials', TextType::class, [
                'label' => 'Materiales',
                'required' => false
            ])
            ->add('Height', NumberType::class, [
                'label' => 'Alto',
                'required' => false
            ])
            ->add('Width', NumberType::class, [
                'label' => 'Ancho',
                'required' => false
            ])
            ->add('Depht', NumberType::class, [
                'label' => 'Profundo',
                'required' => false
            ])
            ->add('Images', FileType::class, [
                'label' => 'Añadir archivo (JPEG, JPG, PNG, WEBP, MP4, MOV, AVI)',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All([
                        new File([
                            'maxSize' => '500M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/jpg',
                                'image/png',
                                'image/webp',
                                'video/mp4',
                                'video/quicktime',
                                'video/x-msvideo',
                            ],
                            'mimeTypesMessage' => 'Formato no válido',
                        ])
                    ]),
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piece::class,
       ]);
    }
}
