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
 * Department Type class.
 */
class DepartmentType extends AbstractType
{
    /**
     * Set default options.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $departments = [];
        $departments['01'] = '01 - Ain';
        $departments['02'] = '02 - Aisne';
        $departments['03'] = '03 - Allier';
        $departments['04'] = '04 - Alpes de Haute Provence';
        $departments['05'] = '05 - Hautes Alpes';
        $departments['06'] = '06 - Alpes Maritimes';
        $departments['07'] = '07 - Ardèche';
        $departments['08'] = '08 - Ardennes';
        $departments['09'] = '09 - Ariège';
        $departments['10'] = '10 - Aube';
        $departments['11'] = '11 - Aude';
        $departments['12'] = '12 - Aveyron';
        $departments['13'] = '13 - Bouches du Rhône';
        $departments['14'] = '14 - Calvados';
        $departments['15'] = '15 - Cantal';
        $departments['16'] = '16 - Charente';
        $departments['17'] = '17 - Charente Maritime';
        $departments['18'] = '18 - Cher';
        $departments['19'] = '19 - Corrèze';
        $departments['2A'] = '2A - Corse du Sud';
        $departments['2B'] = '2B - Haute Corse';
        $departments['21'] = "21 - Côte d'Or";
        $departments['22'] = "22 - Côtes d'Armor";
        $departments['23'] = '23 - Creuse';
        $departments['24'] = '24 - Dordogne';
        $departments['25'] = '25 - Doubs';
        $departments['26'] = '26 - Drôme';
        $departments['27'] = '27 - Eure';
        $departments['28'] = '28 - Eure et Loir';
        $departments['29'] = '29 - Finistère';
        $departments['30'] = '30 - Gard';
        $departments['31'] = '31 - Haute Garonne';
        $departments['32'] = '32 - Gers';
        $departments['33'] = '33 - Gironde';
        $departments['34'] = '34 - Hérault';
        $departments['35'] = '35 - Ille et Vilaine';
        $departments['36'] = '36 - Indre';
        $departments['37'] = '37 - Indre et Loire';
        $departments['38'] = '38 - Isère';
        $departments['39'] = '39 - Jura';
        $departments['40'] = '40 - Landes';
        $departments['41'] = '41 - Loir et Cher';
        $departments['42'] = '42 - Loire';
        $departments['43'] = '43 - Haute Loire';
        $departments['44'] = '44 - Loire Atlantique';
        $departments['45'] = '45 - Loiret';
        $departments['46'] = '46 - Lot';
        $departments['47'] = '47 - Lot et Garonne';
        $departments['48'] = '48 - Lozère';
        $departments['49'] = '49 - Maine et Loire';
        $departments['50'] = '50 - Manche';
        $departments['51'] = '51 - Marne';
        $departments['52'] = '52 - Haute Marne';
        $departments['53'] = '53 - Mayenne';
        $departments['54'] = '54 - Meurthe et Moselle';
        $departments['55'] = '55 - Meuse';
        $departments['56'] = '56 - Morbihan';
        $departments['57'] = '57 - Moselle';
        $departments['58'] = '58 - Nièvre';
        $departments['59'] = '59 - Nord';
        $departments['60'] = '60 - Oise';
        $departments['61'] = '61 - Orne';
        $departments['62'] = '62 - Pas de Calais';
        $departments['63'] = '63 - Puy de Dôme';
        $departments['64'] = '64 - Pyrénées Atlantiques';
        $departments['65'] = '65 - Hautes Pyrénées';
        $departments['66'] = '66 - Pyrénées Orientales';
        $departments['67'] = '67 - Bas Rhin';
        $departments['68'] = '68 - Haut Rhin';
        $departments['69'] = '69 - Rhône';
        $departments['70'] = '70 - Haute Saône';
        $departments['71'] = '71 - Saône et Loire';
        $departments['72'] = '72 - Sarthe';
        $departments['73'] = '73 - Savoie';
        $departments['74'] = '74 - Haute Savoie';
        $departments['75'] = '75 - Paris';
        $departments['76'] = '76 - Seine Maritime';
        $departments['77'] = '77 - Seine et Marne';
        $departments['78'] = '78 - Yvelines';
        $departments['79'] = '79 - Deux Sèvres';
        $departments['80'] = '80 - Somme';
        $departments['81'] = '81 - Tarn';
        $departments['82'] = '82 - Tarn et Garonne';
        $departments['83'] = '83 - Var';
        $departments['84'] = '84 - Vaucluse';
        $departments['85'] = '85 - Vendée';
        $departments['86'] = '86 - Vienne';
        $departments['87'] = '87 - Haute Vienne';
        $departments['88'] = '88 - Vosges';
        $departments['89'] = '89 - Yonne';
        $departments['90'] = '90 - Territoire de Belfort';
        $departments['91'] = '91 - Essonne';
        $departments['92'] = '92 - Hauts de Seine';
        $departments['93'] = '93 - Seine St Denis';
        $departments['94'] = '94 - Val de Marne';
        $departments['95'] = "95 - Val d'Oise";
        $departments['97'] = '97 - DOM';
        $departments = array_flip($departments);

        $resolver->setDefaults([
            'label' => 'form.field.department',
            'help' => 'form.help.department',
            'choices' => $departments,
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
