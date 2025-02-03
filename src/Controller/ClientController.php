<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\Client\ClientFormType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ClientController extends AbstractController
{
    #[Route('/client', name: 'clients_index')]
    public function index(ClientRepository $clientRepository): Response
    {
        $this->denyAccessUnlessGranted('VIEW_CLIENT');

        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'clients' => $clientRepository->findAll(),
        ]);
    }

    #[Route('/clients/new', name: 'client_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $this->denyAccessUnlessGranted('CREATE_CLIENT');

        $client = new Client();
        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($client);
            if (count($errors) > 0) {
                return $this->render('client/client_new.html.twig', [
                    'form' => $form->createView(),
                    'errors' => $errors, // Ajout des erreurs pour affichage
                ]);
            }

            $entityManager->persist($client);
            $entityManager->flush();

            $this->addFlash('success', 'Le client a été ajouté avec succès !');
            return $this->redirectToRoute('clients_index');
        }

        return $this->render('client/client_new.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/clients/edit/{id}', name: 'client_edit')]
    public function edit(Client $client, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $this->denyAccessUnlessGranted('EDIT_CLIENT', $client);

        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($client);
            if (count($errors) > 0) {
                return $this->render('client/client_edit.html.twig', [
                    'form' => $form->createView(),
                    'client' => $client,
                    'errors' => $errors, // Ajout des erreurs pour affichage
                ]);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Le client a été mis à jour avec succès !');
            return $this->redirectToRoute('clients_index');
        }

        return $this->render('client/client_edit.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
        ]);
    }

    #[Route('/clients/delete/{id}', name: 'client_delete', methods: ['POST'])]
    public function delete(Client $client, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('DELETE_CLIENT', $client);

        $entityManager->remove($client);
        $entityManager->flush();

        $this->addFlash('danger', 'Le client a été supprimé avec succès.');
        return $this->redirectToRoute('clients_index');
    }
}
