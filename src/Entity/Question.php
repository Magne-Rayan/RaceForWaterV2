<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;
    /**
     * @var Collection<int, Reponse>
     */
    #[ORM\OneToMany(targetEntity: Reponse::class, mappedBy: 'refQuestion')]
    private Collection $reponses;

    /**
     * @var Collection<int, Score>
     */
    #[ORM\ManyToMany(targetEntity: Score::class, inversedBy: 'questions')]
    private Collection $refScore;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
        $this->refScore = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }
    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): static
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setRefQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): static
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getRefQuestion() === $this) {
                $reponse->setRefQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Score>
     */
    public function getRefScore(): Collection
    {
        return $this->refScore;
    }

    public function addRefScore(Score $refScore): static
    {
        if (!$this->refScore->contains($refScore)) {
            $this->refScore->add($refScore);
        }

        return $this;
    }

    public function removeRefScore(Score $refScore): static
    {
        $this->refScore->removeElement($refScore);

        return $this;
    }
}
