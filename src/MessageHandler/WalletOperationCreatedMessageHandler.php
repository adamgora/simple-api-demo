<?php
declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\WalletOperationCreatedMessage;
use App\Repository\WalletRepository;
use App\Service\WalletAmountCalculator\WalletBalanceCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class WalletOperationCreatedMessageHandler implements MessageHandlerInterface
{
    private WalletRepository $walletRepository;
    private WalletBalanceCalculator $balanceCalculator;
    private EntityManagerInterface $entityManager;

    public function __construct(
        WalletRepository        $walletRepository,
        WalletBalanceCalculator $balanceCalculator,
        EntityManagerInterface  $entityManager
    )
    {
        $this->walletRepository = $walletRepository;
        $this->balanceCalculator = $balanceCalculator;
        $this->entityManager = $entityManager;
    }

    public function __invoke(WalletOperationCreatedMessage $message)
    {

        $wallet = $this->walletRepository->find($message->getWalletId());

        if (!$wallet) {
            return;
        }

        $balance = $this->balanceCalculator->execute($wallet, $wallet->getOperations()->toArray());

        $wallet->setBalance($balance);
        $this->entityManager->persist($wallet);
        $this->entityManager->flush();
    }
}