<?php

namespace App\Entity;

use App\Repository\ImageCommunityManagerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageCommunityManagerRepository::class)]
class ImageCommunityManager
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: MessageCommunityManager::class, inversedBy: 'imagecm')]
    #[ORM\JoinColumn(nullable: false)]
    private $messageCommunityManager;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessageCommunityManager(): ?MessageCommunityManager
    {
        return $this->messageCommunityManager;
    }

    public function setMessageCommunityManager(?MessageCommunityManager $messageCommunityManager): self
    {
        $this->messageCommunityManager = $messageCommunityManager;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
