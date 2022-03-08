<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\ImageCommunityManager;
use App\Entity\MessageCommunityManager;
use App\Form\MessageCommunityManagerType;
use App\Repository\ClientRepository;
use App\Repository\MessageCommunityManagerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/community-manager/message')]
class MessageCommunityManagerController extends AbstractController
{
    #[Route('/', name: 'app_message_community_manager_index', methods: ['GET'])]
    public function index(MessageCommunityManagerRepository $messageCommunityManagerRepository, ClientRepository $clientRepository): Response
    {
        return $this->render('message_community_manager/index.html.twig', [
            'message_community_managers' => $messageCommunityManagerRepository->findAll(),
            'clients' => $clientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_message_community_manager_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessageCommunityManagerRepository $messageCommunityManagerRepository, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $messageCommunityManager = new MessageCommunityManager();
        $form = $this->createForm(MessageCommunityManagerType::class, $messageCommunityManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Je récupére les images transmises
            $images = $form->get('imagecm')->getData();

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

                $img = new ImageCommunityManager();
                $img->setName($fichier);
                $messageCommunityManager->addImagecm($img);
            }
            $entityManager->persist($messageCommunityManager);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            $messageCommunityManagerRepository->add($messageCommunityManager);
            return $this->redirectToRoute('app_message_community_manager_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message_community_manager/new.html.twig', [
            'message_community_manager' => $messageCommunityManager,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_community_manager_show', methods: ['GET'])]
    public function show(MessageCommunityManager $messageCommunityManager): Response
    {
        return $this->render('message_community_manager/show.html.twig', [
            'message_community_manager' => $messageCommunityManager,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_message_community_manager_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MessageCommunityManager $messageCommunityManager, MessageCommunityManagerRepository $messageCommunityManagerRepository, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessageCommunityManagerType::class, $messageCommunityManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Je récupére les images transmises
            $images = $form->get('imagecm')->getData();

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

                $img = new ImageCommunityManager();
                $img->setName($fichier);
                $messageCommunityManager->addImagecm($img);
            }
            $entityManager->persist($messageCommunityManager);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
            $messageCommunityManagerRepository->add($messageCommunityManager);
            return $this->redirectToRoute('app_message_community_manager_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message_community_manager/edit.html.twig', [
            'message_community_manager' => $messageCommunityManager,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_community_manager_delete', methods: ['POST'])]
    public function delete(Request $request, MessageCommunityManager $messageCommunityManager, MessageCommunityManagerRepository $messageCommunityManagerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $messageCommunityManager->getId(), $request->request->get('_token'))) {
            $messageCommunityManagerRepository->remove($messageCommunityManager);
        }

        return $this->redirectToRoute('app_message_community_manager_index', [], Response::HTTP_SEE_OTHER);
    }
}
