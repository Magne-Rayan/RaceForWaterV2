<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse = null;

    #[ORM\Column]
    private ?bool $correction = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    private ?Question $refQuestion = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): static
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function isCorrection(): ?bool
    {
        return $this->correction;
    }

    public function setCorrection(bool $correction): static
    {
        $this->correction = $correction;

        return $this;
    }

    public function getRefQuestion(): ?Question
    {
        return $this->refQuestion;
    }

    public function setRefQuestion(?Question $refQuestion): static
    {
        $this->refQuestion = $refQuestion;

        return $this;
    }
}
