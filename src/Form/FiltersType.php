<?php

namespace App\Form;

use App\Entity\Species;
use App\Form\Model\AdvertisementFilter;
use App\Repository\SpeciesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('date', DateType::class, [
            'required' => false,
        ])
        ->add('species', EntityType::class, [
            'class' => Species::class,
            'expanded' => false,
            'label' => 'espèce',
            'required' => false,
            'choice_label' => 'name',
                'query_builder' => function (SpeciesRepository $spc) {
                    return $spc->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
        ])
        ->add('isLof', CheckboxType::class, [
            'required' => false,
        ])
        ->add('acceptOtherAnimals', CheckboxType::class, [
            'required' => false,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Rechercher']);
    }   

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdvertisementFilter::class,
        ]);
    }
}
