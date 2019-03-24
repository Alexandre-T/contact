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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Region Type class.
 */
class RegionType extends AbstractType
{
    /**
     * Set default options.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $regions = [];
        $regions['FR-ARA'] = 'Auvergne-Rhône-Alpes';
        $regions['FR-BFC'] = 'Bourgogne-Franche-Comté';
        $regions['FR-BRE'] = 'Bretagne';
        $regions['FR-CVL'] = 'Centre-Val de Loire';
        $regions['FR-COR'] = 'Corse';
        $regions['FR-GES'] = 'Grand-Est';
        $regions['FR-HDF'] = 'Hauts-de-France';
        $regions['FR-IDF'] = 'Île-de-France';
        $regions['FR-NOR'] = 'Normandie';
        $regions['FR-NAQ'] = 'Nouvelle-Aquitaine';
        $regions['FR-OCC'] = 'Occitanie';
        $regions['FR-PDL'] = 'Pays de la Loire';
        $regions['FR-PAC'] = 'Provence-Alpes-Côte d’Azur';
        $regions['FR-UMA'] = 'Régions ultramarines (DOM)';
        $regions = array_flip($regions);

        $resolver->setDefaults([
            'label' => 'form.field.region',
            'help' => 'form.help.region',
            'choices' => $regions,
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
        return ChoiceType::class;
    }
}
