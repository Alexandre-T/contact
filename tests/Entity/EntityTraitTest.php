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
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class EntityTraitTest extends TestCase
{
    /**
     * Trait to test.
     * Organization is using entity trait to implement information and entity interfaces.
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
        self::assertNull($this->organization->getCreated());
        self::assertNull($this->organization->getCreator());
        self::assertNull($this->organization->getUpdated());
    }

    /**
     * Test the method GetCreator.
     */
    public function testGetCreator()
    {
        $expected = $actual = new User();

        self::assertEquals($this->organization, $this->organization->setCreator($actual));
        self::assertEquals($expected, $this->organization->getCreator());
    }
}
