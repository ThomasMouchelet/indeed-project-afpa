<?php

namespace App\DataFixtures;

use App\Entity\ContractType;
use App\Entity\Offer;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [ContractFixtures::class, ContractTypeFixtures::class];
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {
            $offer = new Offer();
            $offer
                ->setTitle("Title $i")
                ->setDescription("Description $i")
                ->setPostalCode("33000")
                ->setAddresse("1 rue notre dame")
                ->setCity("bordeaux")
                ->setCreatedAt(new DateTime());

            $contract = $this->getReference("contract_" . rand(0, 2));
            $offer->setContract($contract);

            $contractType = $this->getReference("contract_type_" . rand(0, 1));
            $offer->setContractType($contractType);

            $manager->persist($offer);
        }

        $manager->flush();
    }
}
