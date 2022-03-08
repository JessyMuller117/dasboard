<?php

namespace App\Controller;

use App\Entity\ImageCommunityManager;
use App\Form\ImageCommunityManagerType;
use App\Repository\ImageCommunityManagerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/image/community/manager')]
class ImageCommunityManagerController extends AbstractController
{
    #[Route('/', name: 'app_image_community_manager_index', methods: ['GET'])]
    public function index(ImageCommunityManagerRepository $imageCommunityManagerRepository): Response
    {
        return $this->render('image_community_manager/index.html.twig', [
            'image_community_managers' => $imageCommunityManagerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_image_community_manager_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ImageCommunityManagerRepository $imageCommunityManagerRepository): Response
    {
        $imageCommunityManager = new ImageCommunityManager();
        $form = $this->createForm(ImageCommunityManagerType::class, $imageCommunityManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageCommunityManagerRepository->add($imageCommunityManager);
            return $this->redirectToRoute('app_image_community_manager_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('image_community_manager/new.html.twig', [
            'image_community_manager' => $imageCommunityManager,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_community_manager_show', methods: ['GET'])]
    public function show(ImageCommunityManager $imageCommunityManager): Response
    {
        return $this->render('image_community_manager/show.html.twig', [
            'image_community_manager' => $imageCommunityManager,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_image_community_manager_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ImageCommunityManager $imageCommunityManager, ImageCommunityManagerRepository $imageCommunityManagerRepository): Response
    {
        $form = $this->createForm(ImageCommunityManagerType::class, $imageCommunityManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageCommunityManagerRepository->add($imageCommunityManager);
            return $this->redirectToRoute('app_image_community_manager_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('image_community_manager/edit.html.twig', [
            'image_community_manager' => $imageCommunityManager,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_community_manager_delete', methods: ['POST'])]
    public function delete(Request $request, ImageCommunityManager $imageCommunityManager, ImageCommunityManagerRepository $imageCommunityManagerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imageCommunityManager->getId(), $request->request->get('_token'))) {
            $imageCommunityManagerRepository->remove($imageCommunityManager);
        }

        return $this->redirectToRoute('app_image_community_manager_index', [], Response::HTTP_SEE_OTHER);
    }
}
