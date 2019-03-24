<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @user Entity
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests\unit\Form;

use App\Entity\User;
use App\Form\UserForm;
use Symfony\Component\Form\Test\TypeTestCase;

class UserFormTest extends TypeTestCase
{
    /**
     * Test submitted data.
     */
    public function testSubmitValidData()
    {
        $formData = [
            'label' => 'label',
            'mail' => 'mail',
        ];

        $userToCompare = new User();
        // $user will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(UserForm::class, $userToCompare);

        $user = new User();
        $user->setLabel('label');
        $user->setMail('mail');

        // submit the data to the form directly
        $form->submit($formData);
        self::assertTrue($form->isSynchronized());

        self::assertEquals($user, $userToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            self::assertArrayHasKey($key, $children);
        }
    }
}
