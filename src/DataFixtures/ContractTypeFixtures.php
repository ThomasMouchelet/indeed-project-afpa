<?php

namespace App\DataFixtures;

use App\Entity\ContractType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContractTypeFixtures extends Fixture
{
    const CONTRACTS_TYPES = ["temps pleins", "temps partiel"];

    public function load(ObjectManager $manager)
    {
        foreach (self::CONTRACTS_TYPES as $key => $value) {
            $contractType = new ContractType();
            $contractType->setName($value);

            $this->addReference("contract_type_$key", $contractType);

            $manager->persist($contractType);
        }

        $manager->flush();
    }
}
