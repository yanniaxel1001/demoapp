<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistroFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nombre: '
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Apellido: '
            ])
            ->add('username', TextType::class,[
                'label' => 'Nombre de usuario: '
            ])
            ->add('email', EmailType::class,[
                'label' => 'Correo Electronico: '
            ])        
            ->add('plainPassword', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Las contraseñas deben coincidir.',
                'first_options'  => ['label' => 'Contraseña'],
                'second_options' => ['label' => 'Repetir Contraseña'],
                'mapped' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
?>