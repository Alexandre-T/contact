<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @thematic Fixtures
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 */

namespace App\DataFixtures;

use App\Entity\Thematic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * ThematicFixtures class.
 *
 * Load thematic.
 */
class ThematicFixtures extends Fixture
{
    /**
     * Load manager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $index = 0;
        if (false !== ($handle = fopen(__DIR__.DIRECTORY_SEPARATOR.'thematic.csv', 'r'))) {
            while (false !== ($data = fgetcsv($handle, 1000, ';'))) {
                $thematic = new Thematic();
                $thematic->setCode($data[0]);
                $thematic->setLabel($data[1]);
                $this->addReference('thematic_'.$index++, $thematic);
                $manager->persist($thematic);
            }
            fclose($handle);
        }
        $manager->flush();
    }
}
