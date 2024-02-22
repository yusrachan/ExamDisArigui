<?php

namespace App\Entity;

use App\Repository\RepresentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepresentationRepository::class)]
class Representation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'representations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Showw $the_show = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $the_date = null;

    #[ORM\ManyToOne(inversedBy: 'representations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $the_location = null;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'representation')]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheShow(): ?Showw
    {
        return $this->the_show;
    }

    public function setTheShow(?Showw $the_show): static
    {
        $this->the_show = $the_show;

        return $this;
    }

    public function getTheDate(): ?\DateTimeInterface
    {
        return $this->the_date;
    }

    public function setTheDate(\DateTimeInterface $the_date): static
    {
        $this->the_date = $the_date;

        return $this;
    }

    public function getTheLocation(): ?Location
    {
        return $this->the_location;
    }

    public function setTheLocation(?Location $the_location): static
    {
        $this->the_location = $the_location;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setRepresentation($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRepresentation() === $this) {
                $reservation->setRepresentation(null);
            }
        }

        return $this;
    }
}
