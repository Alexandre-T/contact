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
use App\Entity\PostalAddress;
use App\Repository\PostalAddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * PostalAddress repository test class.
 *
 * Test the postalAddress repository.
 */
class PostalAddressRepositoryTest extends KernelTestCase
{
    /**
     * Entity manager.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * PostalAddress Repository.
     *
     * @var PostalAddressRepository
     */
    private $postalAddressRepository;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->postalAddressRepository = $this->entityManager->getRepository(PostalAddress::class);
    }

    /**
     * Test the findByCountryCode method.
     */
    public function testFindByCountryCode()
    {
        $expected = 4;

        $postalAddresses = $this->postalAddressRepository->findByCountryCode(Country::FRANCE);
        self::assertNotEmpty($postalAddresses);
        self::assertCount($expected, $postalAddresses);
    }

    /**
     * Test the findByFrenchDepartment method.
     */
    public function testFindByFrenchDepartment()
    {
        //Allier (to test postal code with 03 and 33)
        $expected = 1;
        $postalAddresses = $this->postalAddressRepository->findByFrenchDepartment(3);
        self::assertNotEmpty($postalAddresses);
        self::assertCount($expected, $postalAddresses);

        //Gironde
        $expected = 2;
        $postalAddresses = $this->postalAddressRepository->findByFrenchDepartment(33);
        self::assertNotEmpty($postalAddresses);
        self::assertCount($expected, $postalAddresses);

        //Réunion 974
        $expected = 1;
        $postalAddresses = $this->postalAddressRepository->findByFrenchDepartment(974);
        self::assertNotEmpty($postalAddresses);
        self::assertCount($expected, $postalAddresses);
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
