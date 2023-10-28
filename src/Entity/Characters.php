<?php

namespace App\Entity;

use App\Repository\CharactersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharactersRepository::class)]
class Characters
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $mass;

    #[ORM\Column(length: 255)]
    private string $height;

    #[ORM\Column(length: 255)]
    private string $gender;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $picture;

    #[ORM\OneToMany(mappedBy: 'character', targetEntity: MoviesCharacters::class, cascade: ['remove'])]
    private $moviesCharacters;

    public function __construct()
    {
        $this->moviesCharacters = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMass(): string
    {
        return $this->mass;
    }

    public function setMass(string $mass): static
    {
        $this->mass = $mass;

        return $this;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function setHeight(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, MoviesCharacters>
     */
    public function getMoviesCharacters(): Collection
    {
        return $this->moviesCharacters;
    }

    public function addMoviesCharacter(MoviesCharacters $moviesCharacter): static
    {
        if (!$this->moviesCharacters->contains($moviesCharacter)) {
            $this->moviesCharacters->add($moviesCharacter);
            $moviesCharacter->setCharacters($this);
        }

        return $this;
    }

    public function removeMoviesCharacter(MoviesCharacters $moviesCharacter): static
    {
        if ($this->moviesCharacters->removeElement($moviesCharacter)) {
            // set the owning side to null (unless already changed)
            if ($moviesCharacter->getCharacters() === $this) {
                $moviesCharacter->setCharacters(null);
            }
        }

        return $this;
    }
}
