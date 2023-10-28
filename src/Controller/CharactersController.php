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
            // Handle file upload
            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('picture')->getData();

            if ($pictureFile) {
                $newFileName = uniqid().'.'.$pictureFile->guessExtension();

                // Move the file to the public directory
                try {
                    $pictureFile->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads/characters',
                        $newFileName
                    );
                } catch (FileException $e) {
                    // Handle file upload error, if needed
                }

                // Set the picture field to the new file path
                $character->setPicture($newFileName);
            }

            // Persist and flush the updated character entity
            $entityManager->persist($character);
            $entityManager->flush();

            // Redirect or return a response as needed
        }

        return $this->render('edit_character.html.twig', [
            'form' => $form->createView(),
            'character' => $character,
        ]);
    }
}