<?php

namespace App\Entity;

use App\Repository\AssociationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssociationsRepository::class)]
class Associations extends User
{
    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'association', targetEntity: advertisements::class)]
    private $asso_ad;

    public function __construct()
    {
        $this->asso_ad = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, advertisements>
     */
    public function getAssoAd(): Collection
    {
        return $this->asso_ad;
    }

    public function addAssoAd(advertisements $assoAd): self
    {
        if (!$this->asso_ad->contains($assoAd)) {
            $this->asso_ad[] = $assoAd;
            $assoAd->setAssociation($this);
        }

        return $this;
    }

    public function removeAssoAd(advertisements $assoAd): self
    {
        if ($this->asso_ad->removeElement($assoAd)) {
            // set the owning side to null (unless already changed)
            if ($assoAd->getAssociation() === $this) {
                $assoAd->setAssociation(null);
            }
        }

        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = parent::getRoles();
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_ASSO';

        return array_unique($roles);
    }
}