<?php
declare(strict_types=1);

namespace App\Service\WalletAmountCalculator;

use App\Entity\Wallet;
use App\Service\WalletAmountCalculator\Factory\OperationCalculationStrategyFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class WalletBalanceCalculator
{
    private OperationCalculationStrategyFactory $calculationStrategyFactory;

    public function __construct(OperationCalculationStrategyFactory $calculationStrategyFactory)
    {

        $this->calculationStrategyFactory = $calculationStrategyFactory;
    }

    public function execute(Wallet $wallet, array $walletOperations): int
    {
        $balance = 0;

        foreach ($walletOperations as $operation) {
            $strategy = $this->calculationStrategyFactory->make($operation);
            $balance = $strategy->calculate($operation, $balance);
        }

        return $balance;
    }
}