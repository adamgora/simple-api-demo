<?php
declare(strict_types=1);

namespace App\Persister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\WalletOperation;
use App\Message\WalletOperationCreatedMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class WalletOperationPersister implements DataPersisterInterface
{
    private DataPersisterInterface $decoratedPersister;
    private MessageBusInterface $messageBus;

    public function __construct(DataPersisterInterface $decoratedPersister, MessageBusInterface $messageBus)
    {
        $this->decoratedPersister = $decoratedPersister;
        $this->messageBus = $messageBus;
    }

    public function supports($data): bool
    {
        return $data instanceof WalletOperation;
    }

    public function persist($data)
    {
        $this->decoratedPersister->persist($data);

        $this->messageBus->dispatch(new WalletOperationCreatedMessage($data->getWallet()->getId()));
    }

    public function remove($data, array $context = [])
    {
        return $this->decoratedPersister->remove($data, $context);
    }
}