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
use PHPUnit\Framework\TestCase;

class OrganizationTest extends TestCase
{
    /**
     * Organization to test.
     *
     * @var Organization
     */
    private $organization;

    /**
     * Setup the organization class to test.
     */
    protected function setUp()
    {
        $this->organization = new Organization();
    }

    /**
     * Test constructor.
     */
    public function testConstructor()
    {
        self::assertNull($this->organization->getId());
        self::assertNull($this->organization->getAcronymDefinition());
        self::assertNull($this->organization->getCreated());
        self::assertNull($this->organization->getCreator());
        self::assertNull($this->organization->getLabel());
        self::assertNull($this->organization->getLegalName());
        self::assertNotNull($this->organization->getServices());
        self::assertEmpty($this->organization->getServices());
        self::assertNull($this->organization->getUpdated());
    }

    /**
     * Test the method GetLegalName.
     */
    public function testGetLegalName()
    {
        $expected = $actual = 'legalName';

        self::assertEquals($this->organization, $this->organization->setLegalName($actual));
        self::assertEquals($expected, $this->organization->getLegalName());
    }

    /**
     * Test the method GetLabel.
     */
    public function testGetLabel()
    {
        $expected = $actual = 'label';

        self::assertEquals($this->organization, $this->organization->setLabel($actual));
        self::assertEquals($expected, $this->organization->getLabel());
    }

    /**
     * Test the method GetAcronymDefinition.
     */
    public function testGetAcronymDefinition()
    {
        $expected = $actual = 'acronymDefinition';

        self::assertEquals($this->organization, $this->organization->setAcronymDefinition($actual));
        self::assertEquals($expected, $this->organization->getAcronymDefinition());
    }
}
