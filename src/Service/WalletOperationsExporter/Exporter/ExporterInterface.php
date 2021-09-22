<?php
declare(strict_types=1);

namespace App\Service\WalletOperationsExporter\Exporter;

use App\Service\FileSystemAdapter\FilesystemAdapterInterface;

interface ExporterInterface
{
    public function export(string $walletId, array $operations, FilesystemAdapterInterface $filesystemAdapter): void;
}