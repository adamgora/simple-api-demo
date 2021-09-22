<?php
declare(strict_types=1);

namespace App\Service\WalletOperationsExporter\Exporter;

use App\Entity\WalletOperation;
use App\Service\FileSystemAdapter\FilesystemAdapterInterface;

class CsvExporter implements ExporterInterface
{
    public function export(string $walletId, array $operations, FilesystemAdapterInterface $filesystemAdapter): void
    {
        $handle = $filesystemAdapter->open(
            sprintf('operations_history_%s.csv', $walletId)
        );

        fputcsv($handle, [
            'operation_id',
            'operation_type',
            'operation_amount'
        ]);

        /** @var WalletOperation $operation */
        foreach ($operations as $operation) {
            fputcsv($handle, [
                $operation->getId(),
                $operation->getType(),
                $operation->getDetails()['amount']
            ]);
        }

        $filesystemAdapter->close($handle);
    }
}