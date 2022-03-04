<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/aaaa', name: 'app_home')]
    public function index(): Response
    {
        $function2 = 'function2';
        return $this->render('home/index.html.twig', [
            'test' => $function2,
        ]);
    }
}
