<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Fixtures
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 */

namespace App\DataFixtures;

use App\Entity\Organization;
use App\Entity\PostalAddress;
use App\Entity\Service;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * OrganizationFixtures class.
 *
 * Load organization.
 */
class OrganizationFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Load manager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        if (in_array(getenv('APP_ENV'), ['dev', 'test'])) {
            /** @var User $organiser */
            $organiser = $this->getReference('user_organiser');

            $organization = new Organization();
            $organization->setLabel('Test-1');
            $manager->persist($organization);

            //We add 39 organizations.
            /** @var Organization[] $organizations */
            $organizations = [];
            foreach (range(0, 39) as $index) {
                $address = new PostalAddress();
                $address->setCountry('FR')
                    ->setPostalCode(sprintf('%02d000', $index));
                $organizations[$index] = new Organization();
                $organizations[$index]->setLabel("Organization-$index")
                    ->setLegalName("Legal name $index")
                    ->setAcronymDefinition("Definition $index")
                    ->setAddress($address)
                    ->setCreator($organiser);
                foreach (range(0, $index % 10) as $subIndex) {
                    $service = new Service();
                    $service->setCreator($organiser);
                    $service->setName("Service O$index-$subIndex");
                    $organizations[$index]->addService($service);
                }
                $this->addReference("organization_$index", $organizations[$index]);
                $manager->persist($organizations[$index]);
            }
        }
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array
     */
    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
