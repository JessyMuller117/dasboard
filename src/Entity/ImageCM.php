<?php

namespace App\Entity;

use App\Repository\ImageCMRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageCMRepository::class)]
class ImageCM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_image;

    #[ORM\ManyToOne(targetEntity: MessageCM::class, inversedBy: 'imageCMs')]
    #[ORM\JoinColumn(nullable: false)]
    private $messages;

    #[ORM\ManyToOne(targetEntity: MessageCM::class, inversedBy: 'images_cm')]
    private $messageCM;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomImage(): ?string
    {
        return $this->nom_image;
    }

    public function setNomImage(string $nom_image): self
    {
        $this->nom_image = $nom_image;

        return $this;
    }

    public function getMessages(): ?MessageCM
    {
        return $this->messages;
    }

    public function setMessages(?MessageCM $messages): self
    {
        $this->messages = $messages;

        return $this;
    }

    public function getMessageCM(): ?MessageCM
    {
        return $this->messageCM;
    }

    public function setMessageCM(?MessageCM $messageCM): self
    {
        $this->messageCM = $messageCM;

        return $this;
    }
}
