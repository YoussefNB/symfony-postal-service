<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $lastName;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Package", mappedBy="owner")
     */
    private $userPackages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Package", mappedBy="courrier")
     */
    private $courrierPackages;

    public function __construct()
    {
      $this->roles = array('ROLE_USER');
      $this->userPackages = new ArrayCollection();
      $this->courrierPackages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

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

    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function getRoles() {
        return $this->roles;
    }

    public function getUsername() {
        return $this->email;
    }

    /**
     * @return Collection|Package[]
     */
    public function getUserPackages(): Collection
    {
        return $this->userPackages;
    }

    public function addUserPackage(Package $userPackage): self
    {
        if (!$this->userPackages->contains($userPackage)) {
            $this->userPackages[] = $userPackage;
            $userPackage->setOwner($this);
        }

        return $this;
    }

    public function removeUserPackage(Package $userPackage): self
    {
        if ($this->userPackages->contains($userPackage)) {
            $this->userPackages->removeElement($userPackage);
            // set the owning side to null (unless already changed)
            if ($userPackage->getOwner() === $this) {
                $userPackage->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Package[]
     */
    public function getCourrierPackages(): Collection
    {
        return $this->courrierPackages;
    }

    public function addCourrierPackage(Package $courrierPackage): self
    {
        if (!$this->courrierPackages->contains($courrierPackage)) {
            $this->courrierPackages[] = $courrierPackage;
            $courrierPackage->setCourrier($this);
        }

        return $this;
    }

    public function removeCourrierPackage(Package $courrierPackage): self
    {
        if ($this->courrierPackages->contains($courrierPackage)) {
            $this->courrierPackages->removeElement($courrierPackage);
            // set the owning side to null (unless already changed)
            if ($courrierPackage->getCourrier() === $this) {
                $courrierPackage->setCourrier(null);
            }
        }

        return $this;
    }
}
