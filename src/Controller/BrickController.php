<?php

namespace App\Controller;

use App\Entity\Brick;
use App\Entity\Property;
use App\Form\BrickType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/brick")
 */
class BrickController extends AbstractController
{
    /**
     * @Route("/", name="brick_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $bricks = $entityManager
            ->getRepository(Brick::class)
            ->findAll();
        
        $properties = $entityManager
            ->getRepository(Property::class)
            ->findAll();

        return $this->render('brick/index.html.twig', [
            'bricks' => $bricks,
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/new", name="brick_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brick = new Brick();
        $form = $this->createForm(BrickType::class, $brick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brick);
            $entityManager->flush();

            return $this->redirectToRoute('brick_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('brick/new.html.twig', [
            'brick' => $brick,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="brick_show", methods={"GET"})
     */
    public function show(Brick $brick): Response
    {
        return $this->render('brick/show.html.twig', [
            'brick' => $brick,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="brick_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Brick $brick, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrickType::class, $brick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('brick_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('brick/edit.html.twig', [
            'brick' => $brick,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="brick_delete", methods={"POST"})
     */
    public function delete(Request $request, Brick $brick, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brick->getId(), $request->request->get('_token'))) {
            $entityManager->remove($brick);
            $entityManager->flush();
        }

        return $this->redirectToRoute('brick_index', [], Response::HTTP_SEE_OTHER);
    }
}
