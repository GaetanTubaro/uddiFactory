<?php

namespace App\DataFixtures;

use App\Entity\Dogs;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\AdvertisementsRepository;
use App\Repository\SpeciesRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DogsFixtures extends Fixture implements DependentFixtureInterface
{
    protected $advertisementsRepository;
    protected $speciesRepository;

    public function __construct(AdvertisementsRepository $advertisementsRepository, SpeciesRepository $speciesRepository)
    {
        $this->advertisementsRepository = $advertisementsRepository;
        $this->speciesRepository = $speciesRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $dogNames = [
            'Uddi',
            'Couscous',
            'Galbatorix',
            'Eva',
            'Simon',
            'Moustache',
            'Chaussette'
        ];
        $dogPast = [
            'idfodmqhfmoqdhfhdf',
            'fpufîhfdohdfmlslmfh',
            'fùhqdfqkhfmlqdkhfmlq',
            'dqijfùqjdfmlhlmhdfqjm',
            'dfqfqfjaj^jskdjfmmdfj',
            'dsf,dpôviazomljmjmqsjd',
            'dsf,dpôviazomljmjmqsjd',
        ];
        $dogDescription = [
            'dfdqffqohwxcaqohfqjd',
            'dfohqoipmsqdohfqjd',
            'dflkmohqohfdfqfqjd',
            'dfodsqddfqfqhqohfqjd',
            'dfsdqoghjlkhqohfqjd',
            'lkgdjgjdhgkdjklg',
            'lkgdjgjdhgkdjklg',
        ];
        $dogIsLOF = [
            true,
            true,
            false,
            true,
            false,
            true,
            true,
        ];
        $dogIsAdopted = [
            false,
            false,
            false,
            false,
            false,
            false,
            true,
        ];
        $dogOtherAnimal = [
            false,
            true,
            false,
            true,
            false,
            true,
            true,
        ];
        $dogBirth = [
            new DateTime(),
            new DateTime(),
            new DateTime(),
            new DateTime(),
            new DateTime(),
            new DateTime(),
            new DateTime(),
        ];
        $ads = $this->advertisementsRepository->findAll();
        $species = $this->speciesRepository->findAll();
        for ($i = 0; $i < count($dogNames); $i++) {
            $dog = new Dogs();
            $dog->setName($dogNames[$i]);
            $dog->setPast($dogPast[$i]);
            $dog->setDescription($dogDescription[$i]);
            $dog->setIsLOF($dogIsLOF[$i]);
            $dog->setIsAdopted($dogIsAdopted[$i]);
            $dog->setOtherAnimals($dogOtherAnimal[$i]);
            $dog->setBirthDate($dogBirth[$i]);
            $randomAds = mt_rand(0, count($ads) - 1);
            $randomNumber = mt_rand(0, count($species) - 1);
            $dog->setAdvertisement($ads[$randomAds]);
            $dog->addDogSpecies($species[$randomNumber]);
            $manager->persist($dog);
        }
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return [
            AdvertisementsFixtures::class, SpeciesFixtures::class,
        ];
    }
}
