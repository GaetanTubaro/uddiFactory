<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagesRepository::class)]
class Messages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'date')]
    private $creation_date;

    #[ORM\Column(type: 'date', nullable: true)]
    private $suppression_date;

    #[ORM\Column(type: 'boolean')]
    private $isRead;

    #[ORM\ManyToOne(targetEntity: Requests::class, inversedBy: 'message')]
    #[ORM\JoinColumn(nullable: false)]
    private $request;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private $writer;

    public function __construct()
    {
        $this->creation_date = new DateTime();
        $this->isRead = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getSuppressionDate(): ?\DateTimeInterface
    {
        return $this->suppression_date;
    }

    public function setSuppressionDate(?\DateTimeInterface $suppression_date): self
    {
        $this->suppression_date = $suppression_date;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getRequest(): ?Requests
    {
        return $this->request;
    }

    public function setRequest(?Requests $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getWriter(): ?User
    {
        return $this->writer;
    }

    public function setWriter(?User $writer): self
    {
        $this->writer = $writer;

        return $this;
    }
}
