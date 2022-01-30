<?php

namespace App\Entity;

use App\Repository\AdsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdsRepository::class)
 */
class Ads
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=UserProfile::class, inversedBy="adsId")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userID;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="adsId")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUserID(): ?UserProfile
    {
        return $this->userID;
    }

    public function setUserID(?UserProfile $userID): self
    {
        $this->userID = $userID;

        return $this;
    }

    public function getCategoryID(): ?Category
    {
        return $this->categoryID;
    }

    public function setCategoryID(?Category $categoryID): self
    {
        $this->categoryID = $categoryID;

        return $this;
    }

}
