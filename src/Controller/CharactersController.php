<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Characters;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CharacterType;

class CharactersController extends AbstractController
{

    #[Route('/delete/{id}', name: 'delete_character')]
    public function deleteCharacter(EntityManagerInterface $entityManager, Characters $character)
    {
        $entityManager->remove($character);
        $entityManager->flush();

        return $this->redirectToRoute('homepage');
    }

    #[Route('/edit/{id}', name: 'edit_character')]
    public function editCharacter(Request $request, EntityManagerInterface $entityManager, Characters $character)
    {
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle form submission and update the character
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('edit_character.html.twig', [
            'form' => $form->createView(),
            'character' => $character,
        ]);
    }
}