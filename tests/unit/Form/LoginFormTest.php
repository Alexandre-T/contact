<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @login Entity
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests\unit\Form;

use App\Form\LoginForm;
use Symfony\Component\Form\Test\TypeTestCase;

class LoginFormTest extends TypeTestCase
{
    /**
     * Test submitted data
     */
    public function testSubmitValidData()
    {
        $formData = [
            'mail' => 'mail',
            'password' => 'toto',
        ];

        // $objectToCompare will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(LoginForm::class);

        // submit the data to the form directly
        $form->submit($formData);

        self::assertTrue($form->isSynchronized());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            self::assertArrayHasKey($key, $children);
        }
    }
}
