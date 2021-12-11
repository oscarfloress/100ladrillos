<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrickController extends AbstractController
{
    /**
     * @Route("/brick", name="brick")
     */
    public function index(): Response
    {
        return $this->render('brick/index.html.twig', [
            'controller_name' => 'BrickController',
        ]);
    }
}
