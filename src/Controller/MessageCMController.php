<?php

namespace App\Controller;

use App\Entity\ImageCM;
use App\Entity\MessageCM;
use App\Form\MessageCMType;
use App\Repository\MessageCMRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/message-cm')]
class MessageCMController extends AbstractController
{
    #[Route('/', name: 'message_cm_index', methods: ['GET'])]
    public function index(MessageCMRepository $messageCMRepository): Response
    {
        return $this->render('message_cm/index.html.twig', [
            'message_cms' => $messageCMRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'message_cm_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessageCMRepository $messageCMRepository,ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $messageCM = new MessageCM();
        $form = $this->createForm(MessageCMType::class, $messageCM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Je récupére les images transmises
            $images = $form->get('imageCMs')->getData();

            //On boucle sur les images
            foreach ($images as $image) {
                //Je génére un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                //Je copie le fichier dnas le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $entityManager = $doctrine->getManager();

                $img = new ImageCM();
                $img->setNomImage($fichier);
                $messageCM->addImageCM($img);
            }
            $entityManager->persist($messageCM);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();


            $messageCMRepository->add($messageCM);
            return $this->redirectToRoute('message_cm_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('message_cm/new.html.twig', [
            'message_cm' => $messageCM,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'message_cm_show', methods: ['GET'])]
    public function show(MessageCM $messageCM): Response
    {
        return $this->render('message_cm/show.html.twig', [
            'message_cm' => $messageCM,
        ]);
    }

    #[Route('/{id}/edit', name: 'message_cm_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MessageCM $messageCM, MessageCMRepository $messageCMRepository, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessageCMType::class, $messageCM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            //Je récupére les images transmises
            $images = $form->get('imageCMs')->getData();

            //On boucle sur les images
            foreach ($images as $image) {
                //Je génére un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                //Je copie le fichier dnas le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $entityManager = $doctrine->getManager();

                $img = new ImageCM();
                $img->setNomImage($fichier);
                $messageCM->addImageCM($img);
            }
            $entityManager->persist($messageCM);
            $entityManager->flush();

            $messageCMRepository->add($messageCM);
            return $this->redirectToRoute('message_cm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message_cm/edit.html.twig', [
            'message_cm' => $messageCM,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'message_cm_delete', methods: ['POST'])]
    public function delete(Request $request, MessageCM $messageCM, MessageCMRepository $messageCMRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $messageCM->getId(), $request->request->get('_token'))) {
            $messageCMRepository->remove($messageCM);
        }

        return $this->redirectToRoute('message_cm_index', [], Response::HTTP_SEE_OTHER);
    }


}
