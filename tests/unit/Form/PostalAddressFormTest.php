<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @postalAddress Entity
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests\unit\Form;

use App\Entity\PostalAddress;
use App\Form\PostalAddressForm;
use Symfony\Component\Form\Test\TypeTestCase;

class PostalAddressFormTest extends TypeTestCase
{
    /**
     * Test submitted data.
     */
    public function testSubmitValidData()
    {
        $formData = [
            'country' => 'FR',
            'locality' => 'locality',
            'postalCode' => '42000',
            'postOfficeBoxNumber' => 'Box42',
            'streetAddress' => 'street',
        ];

        $postalAddressToCompare = new PostalAddress();
        // $postalAddress will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(PostalAddressForm::class, $postalAddressToCompare);

        $postalAddress = new PostalAddress();
        $postalAddress->setCountry('FR');
        $postalAddress->setLocality('locality');
        $postalAddress->setPostalCode('42000');
        $postalAddress->setPostOfficeBoxNumber('Box42');
        $postalAddress->setStreetAddress('street');

        // submit the data to the form directly
        $form->submit($formData);
        self::assertTrue($form->isSynchronized());

        self::assertEquals($postalAddress, $postalAddressToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            self::assertArrayHasKey($key, $children);
        }
    }
}
