<?php
declare(strict_types=1);

namespace App\Service\WalletAmountCalculator\Strategy;

use App\Entity\WalletOperation;

interface StrategyInterface
{
    public function calculate(WalletOperation $walletOperation, int $amount): int;
}