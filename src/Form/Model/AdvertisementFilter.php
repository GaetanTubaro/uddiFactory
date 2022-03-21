<?php

namespace App\Form\Model;

use App\Entity\Species;
use DateTime;

class AdvertisementFilter 
{
    protected ?Species $species = null;
    protected bool $isLof = false;
    protected bool $acceptOtherAnimals = false;
    protected ?DateTime $date = null;

    /**
     * Get the value of species
     *
     * @return string
     */
    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    /**
     * Set the value of species
     *
     * @param Species $species
     *
     * @return self
     */
    public function setSpecies(?Species $species): self
    {
        $this->species = $species;

        return $this;
    }

    /**
     * Get the value of isLof
     *
     * @return bool
     */
    public function getIsLof(): bool
    {
        return $this->isLof;
    }

    /**
     * Set the value of isLof
     *
     * @param bool $isLof
     *
     * @return self
     */
    public function setIsLof(bool $isLof): self
    {
        $this->isLof = $isLof;

        return $this;
    }

    /**
     * Get the value of acceptOtherAnimals
     *
     * @return bool
     */
    public function getAcceptOtherAnimals(): bool
    {
        return $this->acceptOtherAnimals;
    }

    /**
     * Set the value of acceptOtherAnimals
     *
     * @param bool $acceptOtherAnimals
     *
     * @return self
     */
    public function setAcceptOtherAnimals(bool $acceptOtherAnimals): self
    {
        $this->acceptOtherAnimals = $acceptOtherAnimals;

        return $this;
    }

    /**
     * Get the value of date
     *
     * @return DateTime
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @param DateTime $date
     *
     * @return self
     */
    public function setDate(?DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }
}