<?php
declare(strict_types=1);

namespace App\Service\WalletAmountCalculator\Strategy;

use App\Entity\WalletOperation;

class AdditionStrategy implements StrategyInterface
{
    public function calculate(WalletOperation $walletOperation, int $balance): int
    {
        $balance += $walletOperation->getDetails()['amount'];

        return $balance;
    }
}