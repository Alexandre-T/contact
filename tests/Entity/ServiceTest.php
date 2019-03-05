<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Entity
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests\Entity;

use App\Entity\Organization;
use App\Entity\Person;
use App\Entity\Service;
use PHPUnit\Framework\TestCase;

/**
 * Service entity unit test.
 */
class ServiceTest extends TestCase
{
    /**
     * Service to test.
     *
     * @var Service
     */
    private $service;

    /**
     * Setup the service class to test.
     */
    protected function setUp()
    {
        $this->service = new Service();
    }

    /**
     * Test the method __construct.
     */
    public function test__construct()
    {
        self::assertNotNull($this->service->getPeople());
        self::assertNull($this->service->getId());
        self::assertNull($this->service->getCreated());
        self::assertNull($this->service->getCreator());
        self::assertNull($this->service->getName());
        self::assertNull($this->service->getOrganization());
        self::assertNotNull($this->service->getPeople());
        self::assertEmpty($this->service->getPeople());
        self::assertCount(0, $this->service->getPeople());
        self::assertNull($this->service->getUpdated());
    }

    /**
     * Test the method GetPeople.
     */
    public function testGetPeople()
    {
        self::assertEquals($this->service, $this->service->addPerson(new Person()));
        self::assertCount(1, $this->service->getPeople());
    }

    /**
     * Test the method GetOrganization.
     */
    public function testGetOrganization()
    {
        $expected = $actual = new Organization();
        
        self::assertEquals($this->service, $this->service->setOrganization($actual));
        self::assertEquals($expected, $this->service->getOrganization());
    }

    /**
     * Test the method GetName.
     */
    public function testGetName()
    {
        $expected = $actual = 'name';

        self::assertEquals($this->service, $this->service->setName($actual));
        self::assertEquals($expected, $this->service->getName());
    }
}
