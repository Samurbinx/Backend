<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street', TextType::class, ['label' => 'Dirección'])
            ->add('details', TextType::class, ['label' => 'Detalles de dirección', 'required' => false])
            ->add('zipcode', TextType::class, ['label' => 'Código postal'])
            ->add('city', TextType::class, ['label' => 'Ciudad'])
            ->add('province', TextType::class, ['label' => 'Provincia']);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}

