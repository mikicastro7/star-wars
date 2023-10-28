<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Characters;
use App\Entity\Movies;
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

        $io->note("Importing movies");

        $httpClient = HttpClient::create();
        $movies = $httpClient->request('GET', 'https://swapi.dev/api/films')->toArray();
        $characters = $httpClient->request('GET', 'https://swapi.dev/api/people')->toArray();

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

        $insertedCharacterCount = 0;
        
        foreach ($characters["results"] as $i => $character) {
            if ($insertedCharacterCount >= 30) {
                break;
            }
    
            $characterEntity = new Characters();
    
            $characterName = $character["name"];
    
            $existingCharacter = $this->entityManager->getRepository(Characters::class)->findOneBy(['name' => $characterName]);
    
            if (!$existingCharacter) {
                $characterEntity->setName($characterName);
                $characterEntity->setMass($character["mass"]);
                $characterEntity->setHeight($character["height"]);
                $characterEntity->setGender($character["gender"]);
    
                $this->entityManager->persist($characterEntity);
    
                $insertedCharacterCount++;
            }
        }

        $this->entityManager->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
