<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Test
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests\Entity;

use App\Entity\Country;
use PHPUnit\Framework\TestCase;

/**
 * CountryTest class.
 *
 * Test country entity.
 */
class CountryTest extends TestCase
{
    /**
     * Country to test.
     *
     * @var Country
     */
    private $country;

    /**
     * Setup the country class to test.
     */
    protected function setUp()
    {
        $this->country = new Country();
    }

    public function testConstructor()
    {
        self::assertNull($this->country->getId());
        self::assertEquals('WW', $this->country->getAlpha2());
        self::assertEquals('WWW', $this->country->getAlpha3());
        self::assertEquals('Not available', $this->country->getEnglish());
        self::assertEquals('Non disponible', $this->country->getFrench());
        self::assertEquals(0, $this->country->getNumeric());
    }

    /**
     * Test the method GetFrench.
     */
    public function testGetFrench()
    {
        $expected = $actual = 'french';

        self::assertEquals($this->country, $this->country->setFrench($actual));
        self:self::assertEquals($expected, $this->country->getFrench());
    }

    /**
     * Test the method GetAlpha3.
     */
    public function testGetAlpha3()
    {
        $expected = $actual = 'alpha3';

        self::assertEquals($this->country, $this->country->setAlpha3($actual));
        self:self::assertEquals($expected, $this->country->getAlpha3());
    }

    /**
     * Test the method GetEnglish.
     */
    public function testGetEnglish()
    {
        $expected = $actual = 'english';

        self::assertEquals($this->country, $this->country->setEnglish($actual));
        self:self::assertEquals($expected, $this->country->getEnglish());
    }

    /**
     * Test the method GetAlpha2.
     */
    public function testGetAlpha2()
    {
        $expected = $actual = 'alpha2';

        self::assertEquals($this->country, $this->country->setAlpha2($actual));
        self:self::assertEquals($expected, $this->country->getAlpha2());
    }

    /**
     * Test the method GetNumeric.
     */
    public function testGetNumeric()
    {
        $expected = $actual = 42;

        self::assertEquals($this->country, $this->country->setNumeric($actual));
        self:self::assertEquals($expected, $this->country->getNumeric());
    }
}
