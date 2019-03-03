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

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

/**
 * Category entity test class.
 */
class CategoryTest extends TestCase
{
    /**
     * Category to test.
     *
     * @var Category
     */
    private $category;

    /**
     * Setup the category class to test.
     */
    protected function setUp()
    {
        $this->category = new Category();
    }

    /**
     * Test constructor.
     */
    public function testConstruct()
    {
        self::assertNull($this->category->getId());
        self::assertNull($this->category->getLabel());
        self::assertNotNull($this->category->getPeople());
        self::assertEmpty($this->category->getPeople());
    }

    /**
     * Test the method GetLabel.
     */
    public function testGetLabel()
    {
        $expected = $actual = 'label';

        self::assertEquals($this->category, $this->category->setLabel($actual));
        self::assertEquals($expected, $this->category->getLabel());
    }
}
