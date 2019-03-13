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

namespace App\Tests\Entity;

use App\Entity\PostalAddress;
use PHPUnit\Framework\TestCase;

/**
 * Postal Address Test class.
 *
 * Test postal address entity.
 */
class PostalAddressTest extends TestCase
{
    /**
     * Postal address to test.
     *
     * @var PostalAddress
     */
    private $postalAddress;

    /**
     * Setup the postal address class to test.
     */
    protected function setUp()
    {
        $this->postalAddress = new PostalAddress();
    }

    public function testConstructor()
    {
        self::assertNull($this->postalAddress->getId());
        self::assertNull($this->postalAddress->getCountry());
        self::assertNull($this->postalAddress->getLocality());
        self::assertNull($this->postalAddress->getPostalCode());
        self::assertNull($this->postalAddress->getPostOfficeBoxNumber());
        self::assertNull($this->postalAddress->getStreetAddress());
    }

    /**
     * Test the method GetStreetAddress.
     */
    public function testGetStreetAddress()
    {
        $expected = $actual = 'streetAddress';

        self::assertEquals($this->postalAddress, $this->postalAddress->setStreetAddress($actual));
        self::assertEquals($expected, $this->postalAddress->getStreetAddress());
    }

    /**
     * Test the method GetPostalCode.
     */
    public function testGetPostalCode()
    {
        $expected = $actual = 'postalCode';

        self::assertEquals($this->postalAddress, $this->postalAddress->setPostalCode($actual));
        self::assertEquals($expected, $this->postalAddress->getPostalCode());
    }

    /**
     * Test the method GetPostOfficeBoxNumber.
     */
    public function testGetPostOfficeBoxNumber()
    {
        $expected = $actual = 'postOfficeBoxNumber';

        self::assertEquals($this->postalAddress, $this->postalAddress->setPostOfficeBoxNumber($actual));
        self::assertEquals($expected, $this->postalAddress->getPostOfficeBoxNumber());
    }

    /**
     * Test the method GetCountry.
     */
    public function testGetCountry()
    {
        $expected = $actual = 'EN';

        self::assertEquals($this->postalAddress, $this->postalAddress->setCountry($actual));
        self::assertEquals($expected, $this->postalAddress->getCountry());
    }

    /**
     * Test the method GetLocality.
     */
    public function testGetLocality()
    {
        $expected = $actual = 'locality';

        self::assertEquals($this->postalAddress, $this->postalAddress->setLocality($actual));
        self::assertEquals($expected, $this->postalAddress->getLocality());
    }
}
