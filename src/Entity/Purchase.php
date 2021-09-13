<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 */
class Purchase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseDetails::class, mappedBy="purchase")
     */
    private $purchaseDetails;

    public function __construct()
    {
        $this->purchaseDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|PurchaseDetails[]
     */
    public function getPurchaseDetails(): Collection
    {
        return $this->purchaseDetails;
    }

    public function addPurchaseDetail(PurchaseDetails $purchaseDetail): self
    {
        if (!$this->purchaseDetails->contains($purchaseDetail)) {
            $this->purchaseDetails[] = $purchaseDetail;
            $purchaseDetail->setPurchase($this);
        }

        return $this;
    }

    public function removePurchaseDetail(PurchaseDetails $purchaseDetail): self
    {
        if ($this->purchaseDetails->removeElement($purchaseDetail)) {
            // set the owning side to null (unless already changed)
            if ($purchaseDetail->getPurchase() === $this) {
                $purchaseDetail->setPurchase(null);
            }
        }

        return $this;
    }
}
