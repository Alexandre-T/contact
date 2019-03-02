<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Form
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Form;

use App\Entity\PostalAddress;
use App\Form\Type\CountryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostalAddressForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('streetAddress', null, [
                'label' => 'form.address.field.street',
                'help' => 'form.address.help.street',
            ])
            ->add('postOfficeBoxNumber', null, [
                'label' => 'form.address.field.box',
                'help' => 'form.address.help.box',
            ])
            ->add('postalCode', null, [
                'label' => 'form.address.field.code',
                'help' => 'form.address.help.code',
            ])
            ->add('locality', null, [
                'label' => 'form.address.field.locality',
                'help' => 'form.address.help.locality',
            ])
            ->add('country', CountryType::class, [
                'label' => 'form.address.field.country',
                'help' => 'form.address.help.country',
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostalAddress::class,
        ]);
    }
}
