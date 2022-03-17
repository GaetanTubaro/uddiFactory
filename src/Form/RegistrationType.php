<?php

namespace App\Form;

use App\Entity\Adopters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'required' => true,
            ])
            ->add('password',  PasswordType::class, [
                'required' => true,
                
            ])
            ->add('firstName')
            ->add('surname')
            ->add('mail')
            ->add('phone')
            ->add('city')
            ->add('department')
            ->add('child')
            ->add('gotAnimals')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adopters::class,
        ]);
    }
}
