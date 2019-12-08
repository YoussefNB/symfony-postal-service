<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PackageRepository")
 * @Vich\Uploadable
 */
class Package
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $destination;

    /**
     * @ORM\Column(type="float")
     */
    private $weight;

    /**
     * @ORM\Column(type="integer")
     */
    private $ownerId;

    /**
     * @ORM\Column(type="integer")
     */
    private $courrierId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /** 
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /** 
     * @Vich\UploadableField(mapping="packages", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): self
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getCourrierId(): ?int
    {
        return $this->courrierId;
    }

    public function setCourrierId(int $courrierId): self
    {
        $this->courrierId = $courrierId;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
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

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getImage(): ?string {
        return $this->image;
    }
 
    public function setImage(string $image) :self {
     $this->image = $image;
     return $this;
    }
 
    public function getImageFile() {
     return $this->imageFile;
    }
 
    public function setImageFile(File $image=null) :self {
        $this->imageFile = $image;
        return $this;
    }
}
