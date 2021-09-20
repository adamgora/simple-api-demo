<?php
declare(strict_types=1);

namespace App\Tests\Integration\Api\Account;

use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CreateAccountTest extends WebTestCase
{
    private KernelBrowser $client;

    private AccountRepository $accountRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
        $this->accountRepository = self::getContainer()->get(AccountRepository::class);
    }

    public function test_it_creates_wallet_for_specified_account(): void
    {
        $account = $this->accountRepository->findOneBy([]);
        $this->client->jsonRequest('POST', '/api/wallets', [
            'account' => '/api/accounts/' . $account->getId()
        ]);
        $response = $this->client->getResponse();
        self::assertSame($response->getStatusCode(), 201);
        self::assertCount(1, $account->getWallets());
    }

    public function test_it_returns_an_error_when_trying_to_create_wallet_for_non_existent_account(): void
    {
        $this->client->jsonRequest('POST', '/api/wallets', [
            'account' => '/api/accounts/9999'
        ]);
        $response = $this->client->getResponse();
        self::assertSame($response->getStatusCode(), 400);
    }
}