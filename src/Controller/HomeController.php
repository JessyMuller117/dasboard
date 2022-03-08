<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $Bienvenue = 'la team n3web';
        return $this->render('home/index.html.twig', [
            'msg_bienvenue' => $Bienvenue,
        ]);
    }
}
