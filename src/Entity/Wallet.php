<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 * @ApiResource()
 */
class Wallet
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="wallets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

    /**
     * @ORM\Column(type="integer")
     */
    private $balance;

    /**
     * @ORM\OneToMany(targetEntity=WalletOperation::class, mappedBy="wallet")
     */
    private $operations;

    public function __construct()
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->operations = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return Collection|WalletOperation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(WalletOperation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
            $operation->setWallet($this);
        }

        return $this;
    }

    public function removeOperation(WalletOperation $operation): self
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getWallet() === $this) {
                $operation->setWallet(null);
            }
        }

        return $this;
    }
}
