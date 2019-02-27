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

use App\Entity\Person;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Gender twig extension.
 */
class GenderExtension extends AbstractExtension
{
    /**
     * Translator.
     *
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
     * List of filters.
     *
     * @return array
     */
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('gender', [$this, 'genderFilter'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Gender filter.
     *
     * @param int $value
     *
     * @return string
     */
    public function genderFilter(?int $value): string
    {
        switch ($value) {
            case Person::FEMALE:
                return $this->translator->trans('gender.female');
            case Person::MALE:
                return $this->translator->trans('gender.male');
            case Person::OTHER:
                return $this->translator->trans('gender.other');
            default:
                return '<small>'.$this->translator->trans('gender.unknown').'</small>';
        }
    }
}
