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

use App\Entity\Category;
use App\Entity\Organization;
use App\Entity\Person;
use App\Entity\PostalAddress;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * PersonFixtures class.
 *
 * Load person.
 */
class PersonFixtures extends Fixture implements DependentFixtureInterface
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
            /** @var Organization[] $organizations */
            $organizations = [];
            foreach (range(0, 10) as $index) {
                $organizations[$index] = $this->getReference("organization_$index");
            }
            /** @var Category[] $categories */
            $categories = [];
            foreach (range(0, 5) as $index) {
                $categories[$index] = $this->getReference("category_$index");
            }

            $person = new Person();
            $person->setGivenName('Jane')
                ->setBirthName('Birth')
                ->setCategory($categories[5])
                ->setFamilyName('Doe')
                ->setNationality('FR')
                ->setJobTitle('Depute')
                ->setGender(Person::FEMALE)
                ->setMemberOf($organizations[0])
                ->setAlumnus($organizations[1])
                ->setSmartphone('06-62-00-17-42')
                ->setTelephone('05-56-00-17-42')
                ->setFacebook('http://www.facebook.com/jane-doe')
                ->setInstagram('https://www.instagram.com/jane-doe')
                ->setLinkedIn('https://www.linkedin.com/jane-doe')
                ->setTwitter('https://www.twitter.com/JaneDoe')
                ->setYoutube('https://www.youtube.com/jane-doe');
            $person->setCreator($organiser);

            $address = new PostalAddress();
            $address->setCountry('FR')
                ->setStreetAddress('42 street address')
                ->setLocality('Lacanau')
                ->setPostalCode('33680')
                ->setPostOfficeBoxNumber('Box 42')
                ->setCreator($organiser);
            $person->setAddress($address);

            $manager->persist($person);

            $person = new Person();
            $person->setGivenName('John')
                ->setCategory($categories[1])
                ->setFamilyName('Doe')
                ->setNationality('FR')
                ->setJobTitle('Designer')
                ->setGender(Person::MALE)
                ->setMemberOf($organizations[0])
                ->setAlumnus($organizations[1])
                ->setFacebook('http://www.facebook.com/john-doe')
                ->setInstagram('https://www.instagram.com/john-doe')
                ->setLinkedIn('https://www.linkedin.com/john-doe')
                ->setTwitter('https://www.twitter.com/JohnDoe')
                ->setYoutube('https://www.youtube.com/john-doe');
            $person->setCreator($organiser);

            $address = new PostalAddress();
            $address->setCountry('FR')
                ->setStreetAddress('42 street address')
                ->setLocality('Saint-Médard-En-Jalles')
                ->setPostalCode('33160')
                ->setPostOfficeBoxNumber('Box 42')
                ->setCreator($organiser);
            $person->setAddress($address);

            $manager->persist($person);

            //We add 35 persons.
            /** @var Person[] $persons */
            $persons = [];

            foreach (range(0, 35) as $index) {
                $persons[$index] = new Person();
                $persons[$index]->setGivenName("Given$index")
                    ->setBirthName("Birth$index")
                    ->setCategory($categories[$index % 5])
                    ->setFamilyName("Doe$index")
                    ->setNationality('FR')
                    ->setGender($index % Person::OTHER)
                    ->setMemberOf($organizations[$index % 10])
                    ->setSmartphone(sprintf('06-62-00-00-%02d', $index))
                    ->setTelephone(sprintf('05-56-00-00-%02d', $index))
                    ->setFacebook("http://www.facebook.com/jane-doe$index")
                    ->setInstagram("https://www.instagram.com/jane-doe$index")
                    ->setLinkedIn("https://www.linkedin.com/jane-doe$index")
                    ->setTwitter("https://www.twitter.com/JaneDoe$index")
                    ->setYoutube("https://www.youtube.com/jane-doe$index");

                $address = new PostalAddress();
                $address->setCountry('FR')
                    ->setStreetAddress("$index street address")
                    ->setLocality("City $index")
                    ->setPostalCode('03000')
                    ->setPostOfficeBoxNumber("Box $index")
                    ->setCreator($organiser);
                $person->setAddress($address);

                $manager->persist($persons[$index]);
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
        return [
            CategoryFixtures::class,
            OrganizationFixtures::class,
            UserFixtures::class,
        ];
    }
}
