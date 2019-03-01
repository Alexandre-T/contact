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
use App\Entity\PostalAddress;
use PHPUnit\Framework\TestCase;

/**
 * Person test class.
 */
class PersonTest extends TestCase
{
    /**
     * Person to test.
     *
     * @var Person
     */
    private $person;

    /**
     * Setup the person class to test.
     */
    protected function setUp()
    {
        $this->person = new Person();
    }

    public function testConstructor()
    {
        self::assertNull($this->person->getId());
        self::assertNull($this->person->getAddress());
        self::assertNull($this->person->getAlumnus());
        self::assertNull($this->person->getBirthName());
        self::assertNull($this->person->getCreated());
        self::assertNull($this->person->getCreator());
        self::assertNull($this->person->getEmail());
        self::assertNull($this->person->getFamilyName());
        self::assertNull($this->person->getGender());
        self::assertNull($this->person->getGivenName());
        self::assertNull($this->person->getJobTitle());
        self::assertNull($this->person->getMemberOf());
        self::assertNull($this->person->getNationality());
        self::assertNull($this->person->getUpdated());
        self::assertNull($this->person->getUrl());
    }

    /**
     * Test the method GetAddress.
     */
    public function testGetAddress()
    {
        $expected = $actual = new PostalAddress();

        self::assertEquals($this->person, $this->person->setAddress($actual));
        self::assertEquals($expected, $this->person->getAddress());
    }

    /**
     * Test the method GetUrl.
     */
    public function testGetUrl()
    {
        $expected = $actual = 'url';

        self::assertEquals($this->person, $this->person->setUrl($actual));
        self::assertEquals($expected, $this->person->getUrl());
    }

    /**
     * Test the method GetMemberOf.
     */
    public function testGetMemberOf()
    {
        $expected = $actual = new Organization();

        self::assertEquals($this->person, $this->person->setMemberOf($actual));
        self::assertEquals($expected, $this->person->getMemberOf());
    }

    /**
     * Test the method GetGivenName.
     */
    public function testGetGivenName()
    {
        $expected = $actual = 'given name';

        self::assertEquals($this->person, $this->person->setGivenName($actual));
        self::assertEquals($expected, $this->person->getGivenName());
    }

    /**
     * Test the method GetGender.
     */
    public function testGetGender()
    {
        $expected = $actual = 1;

        self::assertEquals($this->person, $this->person->setGender($actual));
        self::assertEquals($expected, $this->person->getGender());
    }

    /**
     * Test the method GetNationality.
     */
    public function testGetNationality()
    {
        $expected = $actual = 'FR';

        self::assertEquals($this->person, $this->person->setNationality($actual));
        self::assertEquals($expected, $this->person->getNationality());
    }

    /**
     * Test the method GetJobTitle.
     */
    public function testGetJobTitle()
    {
        $expected = $actual = 'job title';

        self::assertEquals($this->person, $this->person->setJobTitle($actual));
        self::assertEquals($expected, $this->person->getJobTitle());
    }

    /**
     * Test the method GetFamilyName.
     */
    public function testGetFamilyName()
    {
        $expected = $actual = 'family name';

        self::assertEquals($this->person, $this->person->setFamilyName($actual));
        self::assertEquals($expected, $this->person->getFamilyName());
    }

    /**
     * Test the method GetEmail.
     */
    public function testGetEmail()
    {
        $expected = $actual = 'test@example.org';

        self::assertEquals($this->person, $this->person->setEmail($actual));
        self::assertEquals($expected, $this->person->getEmail());
    }

    /**
     * Test the method GetBirthName.
     */
    public function testGetBirthName()
    {
        $expected = $actual = 'birth name';

        self::assertEquals($this->person, $this->person->setBirthName($actual));
        self::assertEquals($expected, $this->person->getBirthName());
    }

    /**
     * Test the method GetAlumnus.
     */
    public function testGetAlumnus()
    {
        $expected = $actual = new Organization();

        self::assertEquals($this->person, $this->person->setAlumnus($actual));
        self::assertEquals($expected, $this->person->getAlumnus());
    }
}
