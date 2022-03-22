<?php

namespace App\Form;

use App\Entity\Dogs;
use App\Entity\Requests;
use App\Repository\DogsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdoptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $id = $options['ad_id'];
        $builder
            ->add('dog', EntityType::class, [
                'class' => Dogs::class,
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Chien à adopter :',
                'choice_label' => 'name',
                'query_builder' => function (DogsRepository $dogsRepository) use ($id) {
                    return $dogsRepository->createQueryBuilder('d')
                    ->where('d.advertisement = :id')
                    ->setParameter('id', $id)
                    ->andWhere('d.isAdopted = :isAdopted')
                    ->setParameter('isAdopted', false)
                    ->orderBy('d.name', 'ASC');
                },
            ])
            ->add('message', CollectionType::class, [
                'entry_type' => MessageType::class,
                'entry_options' => [
                    'label' => false,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Requests::class,
            'ad_id' => null,
        ]);
    }
}
