<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Characters;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CharactersController extends AbstractController
{

    #[Route('/delete/{id}', name: 'delete_character')]
    public function deleteCharacter(EntityManagerInterface $entityManager, Characters $character)
    {
        $entityManager->remove($character);
        $entityManager->flush();

        return $this->redirectToRoute('homepage');
    }
}