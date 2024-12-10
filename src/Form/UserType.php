<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, ['label' => 'Correo Electrónico'])
            ->add('name', null, ['label' => 'Nombre'])
            ->add('surname', null, ['label' => 'Apellido'])
            ->add('nick', null, ['label' => 'Apodo'])
            ->add('phone', null, ['label' => 'Teléfono'])
            ->add('address', AddressType::class, [
                'label' => false,
                'mapped' => true,
                'required'=> false,
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'choices' => [
                    'Administrador' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('password', null, ['label' => 'Contraseña']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
