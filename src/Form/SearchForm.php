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

use App\Form\Type\CategoryType;
use App\Form\Type\DepartmentType;
use App\Form\Type\RegionType;
use App\Form\Type\ThematicType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * search form class.
 */
class SearchForm extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', TextType::class, [
                'label' => 'form.field.search',
                'required' => false,
            ])
            ->add('category', CategoryType::class, [
                'help' => null,
                'required' => false,
            ])
            ->add('thematic', ThematicType::class, [
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('region', RegionType::class)
            ->add('department', DepartmentType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'form.submit.search',
            ])
            ->setMethod('get');
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
