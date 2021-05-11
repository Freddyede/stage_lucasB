<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessagesRepository::class)
 */
class Messages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="received")
     */
    private $receiver;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="userSender")
     */
    private $sender;

    public function __construct()
    {
        $this->sender = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getSender(): Collection
    {
        return $this->sender;
    }

    public function addSender(User $sender): self
    {
        if (!$this->sender->contains($sender)) {
            $this->sender[] = $sender;
            $sender->setUserSender($this);
        }

        return $this;
    }

    public function removeSender(User $sender): self
    {
        if ($this->sender->removeElement($sender)) {
            // set the owning side to null (unless already changed)
            if ($sender->getUserSender() === $this) {
                $sender->setUserSender(null);
            }
        }

        return $this;
    }
}
