<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'label' => 'Estado',
                'choices' => [
                    'Pendiente' => "pending",
                    'Confirmado' => "confirmed",
                    'En preparación' => "processing",
                    'Listo para envío' => "ready_for_shipment",
                    'Enviado' => "shipped",
                    'En tránsito' => "in_transit",
                    'Entregado' => "delivered",
                    'En espera' => "on_hold",
                    'Cancelado' => "canceled",
                    'Devuelto' => "returned",
                    'Reembolsado' => "refunded",
                    'Extraviado' => "lost",
                ],
                'required' => true,
                'placeholder' => 'Selecciona una opción', // Opción por defecto
                'data' => 'pending', // Valor predeterminado seleccionado
            ])
            ->add('street', TextType::class, ['label' => 'Dirección'])
            ->add('details', TextType::class, ['label' => 'Detalles de dirección', 'required' => false])
            ->add('zipcode', TextType::class, ['label' => 'Código postal'])
            ->add('city', TextType::class, ['label' => 'Ciudad'])
            ->add('province', TextType::class, ['label' => 'Provincia']);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
