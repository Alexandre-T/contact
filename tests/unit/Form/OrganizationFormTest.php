<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @organization Entity
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests\unit\Form;

use App\Entity\Organization;
use App\Entity\PostalAddress;
use App\Form\OrganizationForm;
use Symfony\Component\Form\Test\TypeTestCase;

class OrganizationFormTest extends TypeTestCase
{
    /**
     * Test submitted data.
     */
    public function testSubmitValidData()
    {
        $formData = [
            'label' => 'label',
            'legalName' => 'legalName',
            'acronymDefinition' => 'acronym',
        ];

        $organizationToCompare = new Organization();
        // $organization will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(OrganizationForm::class, $organizationToCompare);

        $organization = new Organization();
        $organization->setLabel('label');
        $organization->setLegalName('legalName');
        $organization->setAcronymDefinition('acronym');
        $organization->setAddress(new PostalAddress());

        // submit the data to the form directly
        $form->submit($formData);
        self::assertTrue($form->isSynchronized());

        self::assertEquals($organization, $organizationToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            self::assertArrayHasKey($key, $children);
        }
    }
}
