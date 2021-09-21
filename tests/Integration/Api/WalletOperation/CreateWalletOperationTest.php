<?php
declare(strict_types=1);

namespace App\Tests\Integration\Api\WalletOperation;

use App\Enum\WalletOperationTypeEnum;
use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateWalletOperationTest extends WebTestCase
{
    private KernelBrowser $client;
    private WalletRepository $walletRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
        $this->walletRepository = self::getContainer()->get(WalletRepository::class);
    }

    public function test_it_creates_operation(): void
    {
        $wallet = $this->walletRepository->findOneBy([]);

        $this->client->jsonRequest('POST', '/api/wallet_operations', [
            'wallet' => '/api/wallets/' . $wallet->getId(),
            'type' => WalletOperationTypeEnum::ADDITION,
            'details' => [
                'amount' => 150
            ]
        ]);

        $response = $this->client->getResponse();
        self::assertSame($response->getStatusCode(), 201);
        self::assertCount(1, $wallet->getOperations());
    }

    public function test_it_fails_if_improper_type_is_passed(): void
    {
        $wallet = $this->walletRepository->findOneBy([]);

        $this->client->jsonRequest('POST', '/api/wallet_operations', [
            'wallet' => '/api/wallets/' . $wallet->getId(),
            'type' => 'SOME_WRONG_TYPE',
            'details' => [
                'amount' => 150
            ]
        ]);

        $response = $this->client->getResponse();
        self::assertSame($response->getStatusCode(), 422);
    }

    public function test_it_fails_if_improper_type_is_no_amount_is_passed(): void
    {
        $wallet = $this->walletRepository->findOneBy([]);

        $this->client->jsonRequest('POST', '/api/wallet_operations', [
            'wallet' => '/api/wallets/' . $wallet->getId(),
            'type' => 'SOME_WRONG_TYPE',
            'details' => []
        ]);

        $response = $this->client->getResponse();
        self::assertSame($response->getStatusCode(), 422);
    }
}