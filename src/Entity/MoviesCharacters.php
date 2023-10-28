<?php

namespace App\Entity;

use App\Repository\MoviesCharactersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoviesCharactersRepository::class)]
class MoviesCharacters
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'moviesCharacters')]
    #[ORM\JoinColumn(nullable: false)]
    private Movies $movie;

    #[ORM\ManyToOne(inversedBy: 'moviesCharacters')]
    private Characters $character;

    public function getId(): int
    {
        return $this->id;
    }

    public function getMovie(): Movies
    {
        return $this->movie;
    }

    public function setMovie(Movies $movie): static
    {
        $this->movie = $movie;

        return $this;
    }

    public function getCharacter(): Characters
    {
        return $this->character;
    }

    public function setCharacter(Characters $character): static
    {
        $this->character = $character;

        return $this;
    }
}
