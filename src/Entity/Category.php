<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Showw::class, mappedBy: 'category')]
    private Collection $shows;

    public function __construct()
    {
        $this->shows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Showw>
     */
    public function getShows(): Collection
    {
        return $this->shows;
    }

    public function addShow(Showw $show): static
    {
        if (!$this->shows->contains($show)) {
            $this->shows->add($show);
            $show->setCategory($this);
        }

        return $this;
    }

    public function removeShow(Showw $show): static
    {
        if ($this->shows->removeElement($show)) {
            // set the owning side to null (unless already changed)
            if ($show->getCategory() === $this) {
                $show->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}
