<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Entity
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType as SymfonyUrlType;

/**
 * Twitter Type class.
 */
class TwitterType extends AbstractType
{
    /**
     * Set default options.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'label' => 'form.field.twitter',
            'help' => 'form.help.twitter',
            'icon' => 'twitter',
            'icon_family' => 'brands',
            'required' => false,
        ]);
    }

    /**
     * Provide parent type.
     *
     * @return string
     */
    public function getParent()
    {
        return SymfonyUrlType::class;
    }
}
