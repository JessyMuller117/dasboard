<?php

namespace App\Entity;

use App\Repository\MessageCommunityManagerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageCommunityManagerRepository::class)]
class MessageCommunityManager
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $texte;

    #[ORM\OneToMany(mappedBy: 'messageCommunityManager', targetEntity: ImageCommunityManager::class, orphanRemoval: true, cascade: ['persist'])]
    private $imagecm;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'message')]
    private $client;

    public function __construct()
    {
        $this->imagecm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(?string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * @return Collection<int, ImageCommunityManager>
     */
    public function getImagecm(): Collection
    {
        return $this->imagecm;
    }

    public function addImagecm(ImageCommunityManager $imagecm): self
    {
        if (!$this->imagecm->contains($imagecm)) {
            $this->imagecm[] = $imagecm;
            $imagecm->setMessageCommunityManager($this);
        }

        return $this;
    }

    public function removeImagecm(ImageCommunityManager $imagecm): self
    {
        if ($this->imagecm->removeElement($imagecm)) {
            // set the owning side to null (unless already changed)
            if ($imagecm->getMessageCommunityManager() === $this) {
                $imagecm->setMessageCommunityManager(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
