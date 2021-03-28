<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $assignee;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=RealEstates::class, mappedBy="realEstates")
     */
    private $realEstates;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $inspectionDate;

    public function __construct()
    {
        $this->realEstates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssignee(): ?string
    {
        return $this->assignee;
    }

    public function setAssignee(string $assignee): self
    {
        $this->assignee = $assignee;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|RealEstates[]
     */
    public function getRealEstates(): Collection
    {
        return $this->realEstates;
    }

    public function addRealEstate(RealEstates $realEstate): self
    {
        if (!$this->realEstates->contains($realEstate)) {
            $this->realEstates[] = $realEstate;
            $realEstate->setRealEstates($this);
        }

        return $this;
    }

    public function removeRealEstate(RealEstates $realEstate): self
    {
        if ($this->realEstates->removeElement($realEstate)) {
            // set the owning side to null (unless already changed)
            if ($realEstate->getRealEstates() === $this) {
                $realEstate->setRealEstates(null);
            }
        }

        return $this;
    }

    public function getInspectionDate(): ?string
    {
        return $this->inspectionDate;
    }

    public function setInspectionDate(string $inspectionDate): self
    {
        $this->inspectionDate = $inspectionDate;

        return $this;
    }
}
