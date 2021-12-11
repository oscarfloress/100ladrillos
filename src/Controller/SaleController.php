<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Form\SaleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sale")
 */
class SaleController extends AbstractController
{
    /**
     * @Route("/", name="sale_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $sales = $entityManager
            ->getRepository(Sale::class)
            ->findAll();

        return $this->render('sale/index.html.twig', [
            'sales' => $sales,
        ]);
    }

    /**
     * @Route("/new", name="sale_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sale = new Sale();
        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sale);
            $entityManager->flush();

            return $this->redirectToRoute('sale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sale/new.html.twig', [
            'sale' => $sale,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="sale_show", methods={"GET"})
     */
    public function show(Sale $sale): Response
    {
        return $this->render('sale/show.html.twig', [
            'sale' => $sale,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sale_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sale $sale, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('sale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sale/edit.html.twig', [
            'sale' => $sale,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="sale_delete", methods={"POST"})
     */
    public function delete(Request $request, Sale $sale, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sale->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sale_index', [], Response::HTTP_SEE_OTHER);
    }
}
