<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContributorsRepository")
 */
class Contributors
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Courses", mappedBy="contributors")
     */
    private $course_create;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="contributors", cascade={"persist", "remove"})
     */
    private $user;

   

    public function __construct()
    {
        $this->course_create = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getUserId() : ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection|courses[]
     */
    public function getCourseCreate(): Collection
    {
        return $this->course_create;
    }

    public function addCourseCreate(courses $courseCreate): self
    {
        if (!$this->course_create->contains($courseCreate)) {
            $this->course_create[] = $courseCreate;
            $courseCreate->setContributors($this);
        }

        return $this;
    }

    public function removeCourseCreate(courses $courseCreate): self
    {
        if ($this->course_create->contains($courseCreate)) {
            $this->course_create->removeElement($courseCreate);
            // set the owning side to null (unless already changed)
            if ($courseCreate->getContributors() === $this) {
                $courseCreate->setContributors(null);
            }
        }

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
    
   
}
