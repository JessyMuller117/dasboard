<?php

namespace App\Entity;

use App\Repository\MessageCMRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageCMRepository::class)]
class MessageCM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $titre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $text;

    #[ORM\OneToMany(mappedBy: 'messages', targetEntity: ImageCM::class, orphanRemoval: true, cascade: ['persist'])]
    private $imageCMs;

    #[ORM\OneToMany(mappedBy: 'messageCM', targetEntity: ImageCM::class, cascade: ['persist'])]
    private $images_cm;

    public function __construct()
    {
        $this->imageCMs = new ArrayCollection();
        $this->images_cm = new ArrayCollection();
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, ImageCM>
     */
    public function getImageCMs(): Collection
    {
        return $this->imageCMs;
    }

    public function addImageCM(ImageCM $imageCM): self
    {
        if (!$this->imageCMs->contains($imageCM)) {
            $this->imageCMs[] = $imageCM;
            $imageCM->setMessages($this);
        }

        return $this;
    }

    public function removeImageCM(ImageCM $imageCM): self
    {
        if ($this->imageCMs->removeElement($imageCM)) {
            // set the owning side to null (unless already changed)
            if ($imageCM->getMessages() === $this) {
                $imageCM->setMessages(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ImageCM>
     */
    public function getImagesCm(): Collection
    {
        return $this->images_cm;
    }

    public function addImagesCm(ImageCM $imagesCm): self
    {
        if (!$this->images_cm->contains($imagesCm)) {
            $this->images_cm[] = $imagesCm;
            $imagesCm->setMessageCM($this);
        }

        return $this;
    }

    public function removeImagesCm(ImageCM $imagesCm): self
    {
        if ($this->images_cm->removeElement($imagesCm)) {
            // set the owning side to null (unless already changed)
            if ($imagesCm->getMessageCM() === $this) {
                $imagesCm->setMessageCM(null);
            }
        }

        return $this;
    }
}
