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

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * RolesExtension class.
 *
 * This class declare a Twig filter which translate an array of role or a comma separated string
 * to a translated string of roles
 *
 * @category Twig
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license CeCILL-B V1
 */
class RolesExtension extends \Twig_Extension
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Constructor sets the translator.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Return the new filter: roles.
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            'roles' => new \Twig_SimpleFilter(
                'roles',
                [$this, 'rolesFilter'],
                []
            ),
        );
    }

    /**
     * Roles Filter.
     *
     * @param array|string $roles
     * @param string       $inputDelimiter  input delimiter used to split a string into an array
     * @param string       $outputDelimiter delimiter used to implode the result
     *
     * @return string
     */
    public function rolesFilter($roles, $inputDelimiter = ', ', $outputDelimiter = ' ')
    {
        $result = [];

        if (!is_array($roles)) {
            $roles = explode($inputDelimiter, $roles);
        }

        foreach ($roles as $role) {
            $result[] = $this->translator->trans($role);
        }

        //Tri
        sort($result);

        //ROLE_USER is a technical role, it will not to be displayed.
        if (($key = array_search('ROLE_USER', $result)) !== false) {
            unset($result[$key]);
        }

        return implode($outputDelimiter, $result);
    }

    /**
     * Return Name of extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'roles_extension';
    }
}
