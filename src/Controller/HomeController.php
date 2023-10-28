<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Characters;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    #[Route('/')]
    public function homepage(EntityManagerInterface $entityManager)
    {
        $characters =  $entityManager->getRepository(Characters::class)->findAll();

        return $this->render('character.html.twig', [
            'characters' => $characters,
        ]);
    }
}