<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\FormTypeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Courses", mappedBy="categories")
     */
    private $courses;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
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

    /**
     * @return Collection|Courses[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Courses $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setCategories($this);
        }

        return $this;
    }

    public function removeCourse(Courses $course): self
    {
        if ($this->courses->contains($course)) {
            $this->courses->removeElement($course);
            // set the owning side to null (unless already changed)
            if ($course->getCategories() === $this) {
                $course->setCategories(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function __ToString()
    {
        return $this->name;
    }


}
