<?php

namespace App\Command;

use App\Repository\WalletOperationRepository;
use App\Repository\WalletRepository;
use App\Service\FileSystemAdapter\LocalFilesystemAdapter;
use App\Service\WalletOperationsExporter\Factory\ExporterFactory;
use App\Service\WalletOperationsExporter\WalletOperationsExporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'export:wallet_operations',
    description: 'Exports operation history for wallet in desired format',
)]
class ExportWalletOperationsCommand extends Command
{
    private WalletRepository $repository;
    private ExporterFactory $exporterFactory;
    private LocalFilesystemAdapter $localFilesystemAdapter;

    public function __construct(WalletRepository $repository, ExporterFactory $exporterFactory, LocalFilesystemAdapter $localFilesystemAdapter)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->exporterFactory = $exporterFactory;
        $this->localFilesystemAdapter = $localFilesystemAdapter;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('wallet_id', InputArgument::REQUIRED, 'Wallet identifier')
            ->addOption('format', null, InputOption::VALUE_OPTIONAL, 'Output format')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $walletId = $input->getArgument('wallet_id');
        $format = $input->getOption('format') ?? 'csv';

        $wallet = $this->repository->find($walletId);
        $operations = $wallet->getOperations();

        $exporter = $this->exporterFactory->make($format);
        $exporter->export($walletId, $operations->toArray(), $this->localFilesystemAdapter);

        return Command::SUCCESS;
    }
}
