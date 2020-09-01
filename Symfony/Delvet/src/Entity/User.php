<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * 
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
 
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Courses", inversedBy="users")
     */
    private $course;

    public function __construct()
    {
        $this->course = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetToken;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ConfirmationToken;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nickname;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contributors", mappedBy="user", cascade={"persist", "remove"})
     */
    private $contributors;


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(string $roles): self
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    /**
     * @return Collection|Courses[]
     */
    public function getCourse(): Collection
    {
        return $this->course;
    }

    public function addCourse(Courses $course): self
    {
        if (!$this->course->contains($course)) {
            $this->course[] = $course;
        }

        return $this;
    }

    public function removeCourse(Courses $course): self
    {
        if ($this->course->contains($course)) {
            $this->course->removeElement($course);
        }

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getConfirmationToken(): ?bool
    {
        return $this->ConfirmationToken;
    }

    public function setConfirmationToken(?bool $ConfirmationToken): self
    {
        $this->ConfirmationToken = $ConfirmationToken;

        return $this;
    }

    public function __ToString(){
        return $this->email;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getContributors(): ?Contributors
    {
        return $this->contributors;
    }

    public function setContributors(?Contributors $contributors): self
    {
        $this->contributors = $contributors;

        // set (or unset) the owning side of the relation if necessary
        $newUser = $contributors === null ? null : $this;
        if ($newUser !== $contributors->getUser()) {
            $contributors->setUser($newUser);
        }

        return $this;
    }

   
}
