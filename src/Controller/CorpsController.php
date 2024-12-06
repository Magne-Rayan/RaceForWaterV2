<?php

namespace App\Controller;

use App\Entity\Corps;
use App\Form\CorpsType;
use App\Repository\CorpsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/corps')]
final class CorpsController extends AbstractController
{
    #[Route(name: 'app_corps_index', methods: ['GET'])]
    public function index(CorpsRepository $corpsRepository): Response
    {
        return $this->render('corps/index.html.twig', [
            'corps' => $corpsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_corps_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $corps = new Corps();
        $form = $this->createForm(CorpsType::class, $corps);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($corps);
            $entityManager->flush();

            return $this->redirectToRoute('app_corps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('corps/new.html.twig', [
            'corps' => $corps,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_corps_show', methods: ['GET'])]
    public function show(Corps $corps): Response
    {
        return $this->render('corps/show.html.twig', [
            'corps' => $corps,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_corps_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Corps $corps, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CorpsType::class, $corps);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_corps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('corps/edit.html.twig', [
            'corps' => $corps,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_corps_delete', methods: ['POST'])]
    public function delete(Request $request, Corps $corps, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$corps->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($corps);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_corps_index', [], Response::HTTP_SEE_OTHER);
    }
}
