<?php
declare(strict_types=1);

namespace App\Service\WalletOperationsExporter\Factory;

use App\Service\WalletOperationsExporter\Exporter\CsvExporter;
use App\Service\WalletOperationsExporter\Exporter\ExporterInterface;
use Exception;

class ExporterFactory
{
    /**
     * @throws Exception
     */
    public function make(string $format): ExporterInterface
    {
        if($format === 'csv') {
            return new CsvExporter();
        }

        throw new Exception("Format not allowed");
    }
}