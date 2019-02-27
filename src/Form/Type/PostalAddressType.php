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

namespace App\Form\Type;

use App\Entity\Country;
use App\Entity\PostalAddress;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostalAddressType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('streetAddress', null, [
                'label' => 'form.address.field.street',
                'help' => 'form.address.help.street'
            ])
            ->add('postOfficeBoxNumber', null,[
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
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'query_builder' => function (CountryRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->orderBy('c.french', 'ASC');
                },
                'choice_label' => 'french',
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
