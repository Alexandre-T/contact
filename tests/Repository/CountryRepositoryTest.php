<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Tests
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Country repository test class.
 *
 * Test the country repository.
 */
class CountryRepositoryTest extends KernelTestCase
{
    /**
     * Entity manager.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Country Repository.
     *
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->countryRepository = $this->entityManager->getRepository(Country::class);
    }

    /**
     * Test the findByEnglishFirstLetters method.
     */
    public function testFindByEnglishFirstLetters()
    {
        $expected = 4;

        $countries = $this->countryRepository->findByEnglishFirstLetters('Fr');
        self::assertNotEmpty($countries);
        self::assertCount($expected, $countries);
    }

    /**
     * Test the findByFrenchFirstLetters method.
     */
    public function testFindByFrenchFirstLetters()
    {
        $expected = 5;

        $countries = $this->countryRepository->findByFrenchFirstLetters('F');
        self::assertNotEmpty($countries);
        self::assertCount($expected, $countries);
    }

    /**
     * Test the findOneByCode method.
     */
    public function testFindOneByCode()
    {
        $expected = $actual = 'FR';
        $country = $this->countryRepository->findOneByCode($actual);

        $this->assertInstanceOf(Country::class, $country);
        $this->assertEquals($expected, $country->getAlpha2());
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
