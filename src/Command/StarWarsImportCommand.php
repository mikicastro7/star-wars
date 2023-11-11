<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Characters;
use App\Entity\Movies;
use App\Entity\MoviesCharacters;
use Doctrine\ORM\EntityManagerInterface;


#[AsCommand(
    name: 'starwars:import',
    description: 'Add the characters and movies to the db',
)]
class StarWarsImportCommand extends Command
{
     public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        }

    private $entityManager;

        protected function execute(InputInterface $input, OutputInterface $output): int
    {
            $io = new SymfonyStyle($input, $output);

           $io->note("Requesting data to the API");

        $httpClient = HttpClient::create();
        $movies = $httpClient->request('GET', 'https://swapi.dev/api/films')->toArray();
        $characters = [];
        for ($page = 1; $page <= 3; $page++) {
            $response = $httpClient->request('GET', "https://swapi.dev/api/people?page=$page")->toArray();
            $characters = array_merge($characters, $response['results']);
        }

        $io->note("Import movies");

        foreach ($movies["results"] as $i => $movie) {
            $movieName = $movie["title"];

            $existingMovie = $this->entityManager->getRepository(Movies::class)->findOneBy(['name' => $movieName]);
        
            if (!$existingMovie) {
                $movieEntity = new Movies();
                $movieEntity->setName($movieName);
        
                $this->entityManager->persist($movieEntity);
            }
        }
        $this->entityManager->flush();

        $io->note("Importing character");
        
        foreach ($characters as $i => $character) {
    
            $characterEntity = new Characters();
    
            $characterName = $character["name"];
    
            $existingCharacter = $this->entityManager->getRepository(Characters::class)->findOneBy(['name' => $characterName]);
    
            if (!$existingCharacter) {
                $characterEntity->setName($characterName);
                $characterEntity->setMass($character["mass"]);
                $characterEntity->setHeight($character["height"]);
                $characterEntity->setGender($character["gender"]);
    
                $this->entityManager->persist($characterEntity);
    
            }

            foreach ($character["films"] as $key => $characterFilm) {
                $movieId = basename($characterFilm);

                $movie =  $this->entityManager->getRepository(Movies::class)->find($movieId);

                $moviesCharactersEntity = new MoviesCharacters();

                $moviesCharactersEntity->setMovie($movie);
                if ($existingCharacter) {
                    $moviesCharactersEntity->setCharacter($existingCharacter);
                } else {
                    $moviesCharactersEntity->setCharacter($characterEntity);
                }
                $this->entityManager->persist($moviesCharactersEntity);
            }

        }

        $this->entityManager->flush();

        $io->success('Import finished');

        return Command::SUCCESS;
    }
}
