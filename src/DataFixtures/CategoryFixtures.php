<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Fixtures
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 */

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * CategoryFixtures class.
 *
 * Load category.
 */
class CategoryFixtures extends Fixture
{
    /**
     * Load manager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setLabel('Société privée');
        $this->addReference('category_1', $category);
        $manager->persist($category);

        $category = new Category();
        $category->setLabel('Collectivité territoriale');
        $this->addReference('category_2', $category);
        $manager->persist($category);

        $category = new Category();
        $category->setLabel('Universitaire');
        $this->addReference('category_3', $category);
        $manager->persist($category);

        $category = new Category();
        $category->setLabel('Fonctionnaire d’état');
        $this->addReference('category_4', $category);
        $manager->persist($category);

        $category = new Category();
        $category->setLabel('Élu(e)');
        $this->addReference('category_5', $category);
        $manager->persist($category);

        $category = new Category();
        $category->setLabel('Autre…');
        $this->addReference('category_0', $category);
        $manager->persist($category);

        $manager->flush();
    }
}
