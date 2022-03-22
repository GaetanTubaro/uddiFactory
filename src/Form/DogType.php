<?php

namespace App\Form;

use App\Entity\Dogs;
use App\Entity\Species;
use App\Repository\SpeciesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('birth_date', DateType::class, [
                'required' => true,
                'label' => 'Date de naissance'
            ])
            ->add('past', TextareaType::class, [
                'label' => 'Antécédent du chien'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du chien'
            ])
            ->add('isLof', CheckboxType::class, [
                'required' => false,
                'label' => 'Certifié LOF'
            ])
            ->add('otherAnimals', CheckboxType::class, [
                'required' => false,
                'label' => `Accepte d'autres animaux`
            ])
            ->add('dog_species', EntityType::class, [
                'class' => Species::class,
                'expanded' => true,
                'multiple' => true,
                'label' => 'Espèce(s)',
                'required' => false,
                'choice_label' => 'name',
                'query_builder' => function (SpeciesRepository $spc) {
                    return $spc->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
            ]);
            if ($options['submit']) {
                $builder->add('Ajouter', SubmitType::class);
            }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dogs::class,
            'submit' => false,
        ]);
    }
}
