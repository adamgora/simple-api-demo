<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccountFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $account = new Account();
        $account->setName('FOO ACCOUNT');

        $manager->persist($account);
        $manager->flush();
    }
}
