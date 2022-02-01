<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserProfileRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=UserProfileRepository::class)
 */
class UserProfile implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $vote;

    /**
     * @ORM\OneToMany(targetEntity=Ads::class, mappedBy="userID", cascade={"remove"})
     */
    private $adsId;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="userId", orphanRemoval=true)
     */
    private $commentId;

    public function __construct()
    {
        $this->adsId = new ArrayCollection();
        $this->commentId = new ArrayCollection();
    }

    public function eraseCredentials() {}
    public function getSalt(){}


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }


    public function getRoles(){
        return [$this->getRole()];
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getVote(): ?int
    {
        return $this->vote;
    }

    public function setVote(?int $vote): self
    {
        $this->vote = $vote;

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

    /**
     * @return Collection|Comment[]
     */
    public function getCommentId(): Collection
    {
        return $this->commentId;
    }

    public function addCommentId(Comment $commentId): self
    {
        if (!$this->commentId->contains($commentId)) {
            $this->commentId[] = $commentId;
            $commentId->setUserId($this);
        }

        return $this;
    }

    public function removeCommentId(Comment $commentId): self
    {
        if ($this->commentId->removeElement($commentId)) {
            // set the owning side to null (unless already changed)
            if ($commentId->getUserId() === $this) {
                $commentId->setUserId(null);
            }
        }

        return $this;
    }
}
