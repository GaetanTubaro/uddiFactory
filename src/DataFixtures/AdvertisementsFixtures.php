<?php

namespace App\DataFixtures;

use App\Entity\Advertisements;
use App\Repository\AssociationsRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdvertisementsFixtures extends Fixture implements DependentFixtureInterface
{
    protected $associationsRepository;

    public function __construct(AssociationsRepository $associationsRepository)
    {
        $this->associationsRepository = $associationsRepository;
    }

    public function load(ObjectManager $manager)
    {
        $associations = $this->associationsRepository->findAll();

        $adNames = [
            "Chiens à adopter",
            "Boules de poil cherchent foyers confortables",
            "Portée de chiots à adopter",
            "Offrez une belle fin de vie à ces vieillards",
            "Mignons petits chiens",
            "Adoptez-moi"
        ];

        foreach ($adNames as $name) {
            $ad = new Advertisements;
            $RandNb = mt_rand(0, count($associations)-1);
            $ad->setTitle($name)
        ->setCreationDate(new DateTime())
        ->setAssociation($associations[$RandNb]);
            $manager->persist($ad);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AssociationsFixtures::class,
        ];
    }
}
