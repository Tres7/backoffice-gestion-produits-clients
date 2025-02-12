<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Product\ProductFormType;
use App\Repository\ProductRepository;
use App\Service\ProductCsvExporter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{


    #[Route('/product', name: 'products_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted('VIEW_PRODUCT');

        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAllSortedByPriceDesc(),
        ]);
    }

    #[Route('/products/export', name: 'products_export')]
    public function export(ProductCsvExporter $csvExporter): Response
    {
        $this->addFlash('success', 'Exportation CSV réalisée avec succès !');
        return $csvExporter->exportProducts();
    }

    #[Route('/products/new', name: 'product_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('CREATE_PRODUCT');

        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a été ajouté avec succès !');
            return $this->redirectToRoute('products_index');
        }

        return $this->render('product/product_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products/edit/{id}', name: 'product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('EDIT_PRODUCT', $product);

        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a été modifié avec succès !');
            return $this->redirectToRoute('products_index');
        }

        return $this->render('product/product_edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

    #[Route('/products/delete/{id}', name: 'product_delete', methods: ['POST'])]
    public function delete(Product $product, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('DELETE_PRODUCT', $product);

        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash('danger', 'Le produit a été supprimé avec succès.');
        return $this->redirectToRoute('products_index');
    }
}
