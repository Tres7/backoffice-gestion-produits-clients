<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminUserController extends AbstractController{
    #[Route('/admin/user', name: 'admin_users')]
    public function index(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('manage_users');
        return $this->render('admin_user/index.html.twig', [
            'controller_name' => 'AdminUserController',
            'users' => $userRepository->findAll(),

        ]);
    }

    #[Route('/edit/{id}', name: 'admin_users_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('manage_users');

        $form = $this->createForm(UserEditFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render('admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_users_delete')]
    public function delete(User $user, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('manage_users');

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin_users_index');
    }
}
