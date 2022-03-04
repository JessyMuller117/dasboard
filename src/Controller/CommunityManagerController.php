<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommunityManagerController extends AbstractController
{
    #[Route('/community-manager', name: 'app_community_manager')]
    public function index(): Response
    {
        return $this->render('community_manager/index.html.twig', [
            'controller_name' => 'CommunityManagerController',
        ]);
    }
}
