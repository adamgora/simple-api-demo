<?php
declare(strict_types=1);

namespace App\Service\WalletAmountCalculator\Factory;

use App\Entity\WalletOperation;
use App\Enum\WalletOperationTypeEnum;
use App\Service\WalletAmountCalculator\Strategy\AdditionStrategy;
use App\Service\WalletAmountCalculator\Strategy\NullStrategy;
use App\Service\WalletAmountCalculator\Strategy\StrategyInterface;
use App\Service\WalletAmountCalculator\Strategy\SubtractionStrategy;

class OperationCalculationStrategyFactory
{
    public function make(WalletOperation $walletOperation): StrategyInterface
    {
        return match ($walletOperation->getType()) {
            WalletOperationTypeEnum::ADDITION => new AdditionStrategy(),
            WalletOperationTypeEnum::SUBTRACTION => new SubtractionStrategy(),
            default => new NullStrategy(),
        };

    }
}