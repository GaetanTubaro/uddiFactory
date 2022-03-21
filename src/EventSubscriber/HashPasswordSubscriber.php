<?php

namespace App\EventSubscriber;

use App\Entity\User;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class HashPasswordSubscriber implements EventSubscriberInterface
{
    protected UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => ['updateUserPassword'],
            BeforeEntityPersistedEvent::class => ['updateUserPassword'],
        ];  
    }

    public function updateUserPassword($event)
    {
        /** @var User $entity */
        $entity = $event->getEntityInstance();

        if(!$entity instanceof User || empty($entity->getPlainPassword())) {
            return;
        }

        $entity->setCreationDate(new DateTime());
        $entity->setPassword(
            $this->hasher->hashPassword($entity, $entity->getPlainPassword())
        );
    }   
}