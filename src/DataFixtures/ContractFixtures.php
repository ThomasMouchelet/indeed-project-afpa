<?php

namespace App\DataFixtures;

use App\Entity\Contract;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContractFixtures extends Fixture
{
    const CONTRACTS = ["CDI", "CDD", "Freelance"];

    public function load(ObjectManager $manager)
    {
        foreach (self::CONTRACTS as $key => $value) {
            $contract = new Contract();
            $contract->setName($value);

            $this->addReference("contract_$key", $contract);

            $manager->persist($contract);
        }

        $manager->flush();
    }
}
