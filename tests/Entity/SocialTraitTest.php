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

class SocialTraitTest extends TestCase
{
    /**
     * Trait to test.
     * Organization is using entity trait to implement social interfaces.
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
        self::assertNull($this->organization->getFacebook());
        self::assertNull($this->organization->getInstagram());
        self::assertNull($this->organization->getLinkedIn());
        self::assertNull($this->organization->getTwitter());
        self::assertNull($this->organization->getYoutube());
    }

    /**
     * Test the method facebook getter and setter.
     */
    public function testGetFacebook()
    {
        $expected = $actual = 'facebook';

        self::assertEquals($this->organization, $this->organization->setFacebook($actual));
        self::assertEquals($expected, $this->organization->getFacebook());
    }

    /**
     * Test the method instagram getter and setter.
     */
    public function testGetInstagram()
    {
        $expected = $actual = 'instagram';

        self::assertEquals($this->organization, $this->organization->setInstagram($actual));
        self::assertEquals($expected, $this->organization->getInstagram());
    }

    /**
     * Test the method linkedIn getter and setter.
     */
    public function testGetLinkedIn()
    {
        $expected = $actual = 'linked-in';

        self::assertEquals($this->organization, $this->organization->setLinkedIn($actual));
        self::assertEquals($expected, $this->organization->getLinkedIn());
    }

    /**
     * Test the method twitter getter and setter.
     */
    public function testGetTwitter()
    {
        $expected = $actual = 'twitter';

        self::assertEquals($this->organization, $this->organization->setTwitter($actual));
        self::assertEquals($expected, $this->organization->getTwitter());
    }

    /**
     * Test the method youtube getter and setter.
     */
    public function testGetYoutube()
    {
        $expected = $actual = 'youtube';

        self::assertEquals($this->organization, $this->organization->setYoutube($actual));
        self::assertEquals($expected, $this->organization->getYoutube());
    }
}
