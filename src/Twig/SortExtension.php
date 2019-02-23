<?php
/**
 * This file is part of the Contact Application.
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

namespace App\Twig;

/**
 * Sort extension class.
 *
 * @category Twig
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license CeCILL-B V1
 */
class SortExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'sort' => new \Twig_SimpleFunction(
                'faSort',
                [$this, 'sortFunction'],
                ['is_safe', ['html']]
            ),
        );
    }

    /**
     * sort Function.
     *
     * @param bool $sorted
     * @param string $sort
     * @param string $type
     * @return string
     */
    public function sortFunction(bool $sorted = false, string $sort = 'asc', string $type = null)
    {
        $result = 'fa fa-sort';

        if ($sorted) {
            switch ($type) {
                case 'numeric':
                case 'alpha':
                case 'amount':
                    $result .= "-$type";
            }
            dump($sort);
            $result .= 'desc' == $sort ? '-up' : '-down';
        }

        return $result;
    }

    /**
     * Return Name of extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'sort_extension';
    }
}
