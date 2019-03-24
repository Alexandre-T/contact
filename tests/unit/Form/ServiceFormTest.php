<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @service Entity
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests\unit\Form;

use App\Entity\Service;
use App\Form\ServiceForm;
use Symfony\Component\Form\Test\TypeTestCase;

class ServiceFormTest extends TypeTestCase
{
    /**
     * Test submitted data.
     */
    public function testSubmitValidData()
    {
        $formData = [
            'name' => 'name',
        ];

        $serviceToCompare = new Service();
        // $service will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(ServiceForm::class, $serviceToCompare);

        $service = new Service();
        $service->setName('name');

        // submit the data to the form directly
        $form->submit($formData);
        self::assertTrue($form->isSynchronized());

        self::assertEquals($service, $serviceToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            self::assertArrayHasKey($key, $children);
        }
    }
}
