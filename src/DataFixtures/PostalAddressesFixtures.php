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

use App\Entity\Country;
use App\Entity\PostalAddress;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * PostalAddressFixtures class.
 *
 * Load postalAddress.
 */
class PostalAddressesFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Load manager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        if (in_array(getenv('APP_ENV'), ['dev', 'test'])) {
            /** @var Country $france */
            $france = $this->getReference('country_FR');
            /** @var Country $spain $spain */
            $spain = $this->getReference('country_ES');

            $postal = new PostalAddress();
            $postal->setCountry($france);
            $postal->setPostalCode('03000');
            $postal->setStreetAddress('Allier');
            $postal->setLocality('Moulins');
            $manager->persist($postal);

            $postal = new PostalAddress();
            $postal->setCountry($france);
            $postal->setPostalCode('33680');
            $postal->setStreetAddress('In Gironde');
            $postal->setLocality('Lacanau');
            $manager->persist($postal);

            $postal = new PostalAddress();
            $postal->setCountry($france);
            $postal->setPostalCode('97400');
            $postal->setStreetAddress('DOM-TOM test');
            $postal->setLocality('Saint-Denis');
            $manager->persist($postal);

            $postal = new PostalAddress();
            $postal->setCountry($france);
            $postal->setPostalCode('33160');
            $postal->setStreetAddress('In Gironde');
            $postal->setLocality('Saint-Médard-En-Jalles');
            $manager->persist($postal);

            $postal = new PostalAddress();
            $postal->setCountry($spain);
            $postal->setPostalCode('33000');
            $postal->setStreetAddress('33 not in France');
            $postal->setLocality('Madrid');
            $manager->persist($postal);

            $postal = new PostalAddress();
            $postal->setCountry($spain);
            $postal->setPostalCode('97411');
            $postal->setStreetAddress('not in 33 not in France');
            $postal->setLocality('Bilbao');
            $manager->persist($postal);
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
        return [CountryFixtures::class];
    }
}
