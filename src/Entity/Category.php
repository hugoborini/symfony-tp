<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $category_name;

    /**
     * @ORM\OneToMany(targetEntity=Ads::class, mappedBy="categoryID")
     */
    private $adsId;

    public function __construct()
    {
        $this->adsId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

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
            $adsId->setCategoryID($this);
        }

        return $this;
    }

    public function removeAdsId(Ads $adsId): self
    {
        if ($this->adsId->removeElement($adsId)) {
            // set the owning side to null (unless already changed)
            if ($adsId->getCategoryID() === $this) {
                $adsId->setCategoryID(null);
            }
        }

        return $this;
    }
}
