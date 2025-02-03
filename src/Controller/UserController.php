<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User\UserCreateFormType;
use App\Form\User\UserEditFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController{
    #[Route('/user', name: 'users')]
    public function index(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('VIEW_CLIENT');
        return $this->render('user/index.html.twig', [
            'controller_name' => 'AdminUserController',
            'users' => $userRepository->findAll(),

        ]);
    }

    #[Route('/user/new', name: 'users_new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $this->denyAccessUnlessGranted('CREATE_USER');


        $user = new User();
        $form = $this->createForm(UserCreateFormType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le mot de passe en clair depuis le formulaire
            $plainPassword = $form->get('password')->getData();
            // Hacher le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('users');
        }

        return $this->render('user/user_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/edit/{id}', name: 'users_edit', methods: ['GET', 'POST'])]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('EDIT_USER', $user);

        $form = $this->createForm(UserEditFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('users');
        }

        return $this->render('user/user_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/delete/{id}', name: 'users_delete')]
    public function delete(User $user, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('DELETE_USER',$user);

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('users');
    }
}
