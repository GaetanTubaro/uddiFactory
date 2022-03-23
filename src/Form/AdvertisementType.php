<?php

namespace App\Form;

use App\Entity\Advertisements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertisementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre de votre annonce',
            ])
            ->add('advertisement_dogs', CollectionType::class,[
                'entry_type' => DogType::class,
                'label' => false,
                'entry_options' => [
                    'label' => 'Création chien',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advertisements::class,
        ]);
    }
}
