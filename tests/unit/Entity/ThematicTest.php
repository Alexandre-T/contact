<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @thematic Tests
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests\Entity;

use App\Entity\Thematic;
use PHPUnit\Framework\TestCase;

/**
 * Thematic entity test class.
 */
class ThematicTest extends TestCase
{
    /**
     * Thematic to test.
     *
     * @var Thematic
     */
    private $thematic;

    /**
     * Setup the thematic class to test.
     */
    protected function setUp()
    {
        $this->thematic = new Thematic();
    }

    /**
     * Test constructor.
     */
    public function testConstruct()
    {
        self::assertNull($this->thematic->getId());
        self::assertNull($this->thematic->getCode());
        self::assertNull($this->thematic->getLabel());
    }

    /**
     * Test the method GetCode.
     */
    public function testGetCode()
    {
        $expected = $actual = 'code';

        self::assertEquals($this->thematic, $this->thematic->setCode($actual));
        self::assertEquals($expected, $this->thematic->getCode());
    }

    /**
     * Test the method GetLabel.
     */
    public function testGetLabel()
    {
        $expected = $actual = 'label';

        self::assertEquals($this->thematic, $this->thematic->setLabel($actual));
        self::assertEquals($expected, $this->thematic->getLabel());
    }
}
