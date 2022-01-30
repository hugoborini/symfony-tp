<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=UserProfile::class, inversedBy="commentId")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUserId(): ?UserProfile
    {
        return $this->userId;
    }

    public function setUserId(?UserProfile $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Collection|Ads[]
     */
    public function getAdsId(): Collection
    {
        return $this->adsId;
    }

    public function addAdsId(Ads $adsId): self
    {
        if (!$this->adsId->contains($adsId)) {
            $this->adsId[] = $adsId;
            $adsId->setUserID($this);
        }

        return $this;
    }

    public function removeAdsId(Ads $adsId): self
    {
        if ($this->adsId->removeElement($adsId)) {
            // set the owning side to null (unless already changed)
            if ($adsId->getUserID() === $this) {
                $adsId->setUserID(null);
            }
        }

        return $this;
    }
}
