<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Functional test
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests\functional;

use App\Tests\FunctionalTester;

/**
 * Home Cest.
 *
 * Functional test home controller.
 */
class HomeCest
{
    public function index(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->canSeeResponseCodeIsSuccessful();
    }
}
