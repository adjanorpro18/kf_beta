<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
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
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="activities", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="activity", cascade={"persist", "remove"})
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=Publics::class, inversedBy="activities" , cascade="persist")
     */
    private $publics;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="activity", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $pictures;


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

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function __construct()
    {
        $this->setCreatedAt(new\Datetime());
        $this->comments = new ArrayCollection();
        $this->publics = new ArrayCollection();
        $this->pictures = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
        if ($this->pictures->contains($picture)) {
            $this->removeElement($picture);

            dump($activity);
            // set the owning side to null (unless already changed)
            if ($picture->getActivity() === $this) {
                $picture->setActivity(null);
            }
        }

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

    //rajout de la fonction de compteur pour les commentaires

    public function iscountMessage(): float
    {

        $sum = 0;

        foreach ($this->getComments() as $comment) {
            $sum += $comment->getMessage();
            $total++;
        }
        return $sum;

    }

    public function __toString()
    {
        return $this->name;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
