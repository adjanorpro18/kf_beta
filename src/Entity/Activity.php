<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $decsription;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="activity", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=Publics::class, inversedBy="activities")
     */
    private $publics;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="activity", orphanRemoval=true)
     */
    private $pictures;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="activities")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=TypeActivity::class, inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeActivity;

    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->publics = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDecsription(): ?string
    {
        return $this->decsription;
    }

    public function setDecsription(string $decsription): self
    {
        $this->decsription = $decsription;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setActivity($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getActivity() === $this) {
                $comment->setActivity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Publics[]
     */
    public function getPublics(): Collection
    {
        return $this->publics;
    }

    public function addPublic(Publics $public): self
    {
        if (!$this->publics->contains($public)) {
            $this->publics[] = $public;
        }

        return $this;
    }

    public function removePublic(Publics $public): self
    {
        $this->publics->removeElement($public);

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setActivity($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getActivity() === $this) {
                $picture->setActivity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getTypeActivity(): ?TypeActivity
    {
        return $this->typeActivity;
    }

    public function setTypeActivity(?TypeActivity $typeActivity): self
    {
        $this->typeActivity = $typeActivity;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }
}