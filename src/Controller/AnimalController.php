<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/animal')]
class AnimalController extends AbstractController
{
    #[Route('/', name: 'app_animal_index', methods: ['GET'])]
    public function index(AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->findAll();
        return $this->json([$animals], Response::HTTP_OK);
    }

    #[Route('/new', name: 'app_animals_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animalData = json_decode($request->getContent(), true);
        $country = $entityManager->getRepository('App\Entity\Country')->find($animalData['country']);
        // dd($animalData);
        $animal = new Animal();
        $animal
            ->setName($animalData['name'])
            ->setAverageSize($animalData['averageSize'])
            ->setAverageLifeDuration($animalData['averageLifeDuration'])
            ->setPhoneNumber($animalData['phoneNumber'])
            ->setMartialArt($animalData['martialArt'])
            ->setCountry($country);
        $entityManager->persist($animal);
        $entityManager->flush();
        return $this->json($animal, Response::HTTP_CREATED);
    }

    // #[Route('/new', name: 'app_animal_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, AnimalRepository $animalRepository): Response
    // {
    //     $animal = new Animal();
    //     $form = $this->createForm(AnimalType::class, $animal);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $animalRepository->save($animal, true);

    //         return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('animal/new.html.twig', [
    //         'animal' => $animal,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_animals_show', methods: ['GET'])]
    public function show(Animal $animal): Response
    {
        // return $this->render('animals/show.html.twig', [
        //     'animal' => $animal,
        // ]);
        return $this->json([
            'animal' => $animal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_animals_edit', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, Animal $animal, AnimalRepository $animalsRepository): Response
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(AnimalType::class, $animal);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $animalsRepository->save($animal, true);
            //return $this->redirectToRoute('app_animals_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->json([
            'animal' => $animal,
            'message' => "L'animal a été modifié"
        ], Response::HTTP_OK);

        // return $this->renderForm('animals/edit.html.twig', [
        //     'animal' => $animal,
        //     'form' => $form,
        // ]);
    }

    // #[Route('/{id}/edit', name: 'app_animal_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Animal $animal, AnimalRepository $animalRepository): Response
    // {
    //     $form = $this->createForm(AnimalType::class, $animal);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $animalRepository->save($animal, true);

    //         return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('animal/edit.html.twig', [
    //         'animal' => $animal,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_animal_delete', methods: ['DELETE'])]
    public function delete(Animal $animal, AnimalRepository $animalRepository): Response
    {
        $animalRepository->remove($animal, true);
        return $this->json(['message' => 'Animal supprimé'], Response::HTTP_OK);
    }


    // #[Route('/{id}', name: 'app_animal_delete', methods: ['DELETE'])]
    // public function delete(Request $request, Animal $animal, AnimalRepository $animalRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $animal->getId(), $request->request->get('_token'))) {
    //         $animalRepository->remove($animal, true);
    //     }
    //     return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    // }
}
