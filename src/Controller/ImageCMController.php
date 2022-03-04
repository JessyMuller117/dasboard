<?php

namespace App\Controller;

use App\Entity\ImageCM;
use App\Form\ImageCMType;
use App\Repository\ImageCMRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/image-cm')]
class ImageCMController extends AbstractController
{
    #[Route('/', name: 'app_image_c_m_index', methods: ['GET'])]
    public function index(ImageCMRepository $imageCMRepository): Response
    {
        return $this->render('image_cm/index.html.twig', [
            'image_c_ms' => $imageCMRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_image_c_m_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ImageCMRepository $imageCMRepository): Response
    {
        $imageCM = new ImageCM();
        $form = $this->createForm(ImageCMType::class, $imageCM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageCMRepository->add($imageCM);
            return $this->redirectToRoute('app_image_c_m_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('image_cm/new.html.twig', [
            'image_c_m' => $imageCM,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_c_m_show', methods: ['GET'])]
    public function show(ImageCM $imageCM): Response
    {
        return $this->render('image_cm/show.html.twig', [
            'image_c_m' => $imageCM,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_image_c_m_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ImageCM $imageCM, ImageCMRepository $imageCMRepository): Response
    {
        $form = $this->createForm(ImageCMType::class, $imageCM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageCMRepository->add($imageCM);
            return $this->redirectToRoute('app_image_c_m_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('image_cm/edit.html.twig', [
            'image_c_m' => $imageCM,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_c_m_delete', methods: ['POST'])]
    public function delete(Request $request, ImageCM $imageCM, ImageCMRepository $imageCMRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imageCM->getId(), $request->request->get('_token'))) {
            $imageCMRepository->remove($imageCM);
        }

        return $this->redirectToRoute('app_image_c_m_index', [], Response::HTTP_SEE_OTHER);
    }
}
