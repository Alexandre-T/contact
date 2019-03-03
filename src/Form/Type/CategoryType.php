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

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Category Type class.
 */
class CategoryType extends AbstractType
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
            'class' => Category::class,
            'choice_label' => 'label',
            'label' => 'form.field.category',
            'help' => 'form.help.category',
            'query_builder' => function (CategoryRepository $or) {
                return $or->createQueryBuilder('c')
                    ->orderBy('c.id', 'ASC');
            },
            'required' => true,
        ]);
    }

    /**
     * Provide parent type.
     *
     * @return string
     */
    public function getParent()
    {
        return EntityType::class;
    }
}
