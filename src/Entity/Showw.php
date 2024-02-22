<?php

namespace App\Entity;

use App\Repository\ShowwRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShowwRepository::class)]
class Showw
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?bool $bookable = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poster_url = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'showw')]
    private Collection $reviews;

    #[ORM\ManyToOne(inversedBy: 'shows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'bookable')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\OneToMany(targetEntity: Representation::class, mappedBy: 'the_show', orphanRemoval: true)]
    private Collection $representations;

    #[ORM\ManyToMany(targetEntity: ArtistType::class)]
    private Collection $troupe;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->representations = new ArrayCollection();
        $this->troupe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isBookable(): ?bool
    {
        return $this->bookable;
    }

    public function setBookable(bool $bookable): static
    {
        $this->bookable = $bookable;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPosterUrl(): ?string
    {
        return $this->poster_url;
    }

    public function setPosterUrl(?string $poster_url): static
    {
        $this->poster_url = $poster_url;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setShoww($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getShoww() === $this) {
                $review->setShoww(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, Representation>
     */
    public function getRepresentations(): Collection
    {
        return $this->representations;
    }

    public function addRepresentation(Representation $representation): static
    {
        if (!$this->representations->contains($representation)) {
            $this->representations->add($representation);
            $representation->setTheShow($this);
        }

        return $this;
    }

    public function removeRepresentation(Representation $representation): static
    {
        if ($this->representations->removeElement($representation)) {
            // set the owning side to null (unless already changed)
            if ($representation->getTheShow() === $this) {
                $representation->setTheShow(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ArtistType>
     */
    public function getTroupe(): Collection
    {
        return $this->troupe;
    }

    public function addTroupe(ArtistType $troupe): static
    {
        if (!$this->troupe->contains($troupe)) {
            $this->troupe->add($troupe);
        }

        return $this;
    }

    public function removeTroupe(ArtistType $troupe): static
    {
        $this->troupe->removeElement($troupe);

        return $this;
    }
}
