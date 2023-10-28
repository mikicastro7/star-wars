<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoviesRepository::class)]
class Movies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'movie_id', targetEntity: MoviesCharacters::class)]
    private Collection $moviesCharacters;

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
            $moviesCharacter->setMovieId($this);
        }

        return $this;
    }

    public function removeMoviesCharacter(MoviesCharacters $moviesCharacter): static
    {
        if ($this->moviesCharacters->removeElement($moviesCharacter)) {
            // set the owning side to null (unless already changed)
            if ($moviesCharacter->getMovieId() === $this) {
                $moviesCharacter->setMovieId(null);
            }
        }

        return $this;
    }
}
