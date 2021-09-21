<?php
declare(strict_types=1);

namespace App\Message;

class WalletOperationCreatedMessage
{
    private string $walletId;

    public function __construct(string $walletId)
    {
        $this->walletId = $walletId;
    }

    public function getWalletId(): string
    {
        return $this->walletId;
    }
}