<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Validator\Constraints\WalletOperationDetails;
use App\Validator\Constraints\WalletOperationType;
use App\Repository\WalletOperationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=WalletOperationRepository::class)
 * @ApiResource(
 *     itemOperations={
 *          "get"={"normalization_context"={"groups"="wallet_operations.show"}},
 *     },
 *     collectionOperations={
 *          "post"={"denormalization_context"={"groups"="wallet_operation.store"}},
 *     }
 * )
 */
class WalletOperation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     * @ApiProperty(writableLink=true)
     * @Groups({"wallet_operation.store"})
     */
    private $wallet;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"wallet_operation.store"})
     * @WalletOperationType
     */
    private $type;

    /**
     * @ORM\Column(type="array")
     * @Groups({"wallet_operation.store"})
     * @WalletOperationDetails
     */
    private $details = [];

    public function __construct()
    {
        $this->id = Uuid::v4()->toRfc4122();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function setWallet(?Wallet $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }

    public function setDetails(array $details): self
    {
        $this->details = $details;

        return $this;
    }
}
