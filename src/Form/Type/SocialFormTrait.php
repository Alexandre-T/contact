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

use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Social form trait.
 *
 * Provide a method to add social network fields.
 */
class SocialFormTrait
{
    /**
     * Add social network fields.
     *
     * @param FormBuilderInterface $builder
     *
     * @return FormBuilderInterface
     */
    public function addSocial(FormBuilderInterface $builder): FormBuilderInterface
    {
        return $builder->add('facebook', UrlType::class, [
                'label' => 'form.social.field.facebook',
                'help' => 'form.social.help.facebook',
            ])
            ->add('instagram', UrlType::class, [
                'label' => 'form.social.field.instagram',
                'help' => 'form.social.help.instagram',
            ])
            ->add('linkedIn', UrlType::class, [
                'label' => 'form.social.field.linked-in',
                'help' => 'form.social.help.linked-in',
            ])
            ->add('twitter', UrlType::class, [
                'label' => 'form.social.field.twitter',
                'help' => 'form.social.help.twitter',
            ])
            ->add('youtube', UrlType::class, [
                'label' => 'form.social.field.youtube',
                'help' => 'form.social.help.youtube',
            ])
        ;
    }
}
