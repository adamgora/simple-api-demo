<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WalletFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $wallet = new Wallet();

        $account = new Account();
        $account->setName('WALLETED_ACCOUNT');
        $account->addWallet($wallet);

        $manager->persist($wallet);
        $manager->persist($account);

        $manager->flush();
    }
}
