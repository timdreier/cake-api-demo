<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
#[ApiResource]
#[ApiFilter(SearchFilter::class, properties: ['cake' => 'exact'])]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cake $cake = null;

    #[ORM\Column(nullable: true)]
    private ?int $taste = null;

    #[ORM\Column(nullable: true)]
    private ?int $look = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCake(): ?Cake
    {
        return $this->cake;
    }

    public function setCake(?Cake $cake): static
    {
        $this->cake = $cake;

        return $this;
    }

    public function getTaste(): ?int
    {
        return $this->taste;
    }

    public function setTaste(?int $taste): static
    {
        $this->taste = $taste;

        return $this;
    }

    public function getLook(): ?int
    {
        return $this->look;
    }

    public function setLook(?int $look): static
    {
        $this->look = $look;

        return $this;
    }
}
