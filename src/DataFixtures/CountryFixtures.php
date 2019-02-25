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

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use SplFileInfo;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * CountryFixtures class.
 *
 * Load country.
 */
class CountryFixtures extends Fixture
{
    const CSV_FILE = 'country-ISO_3166-1.csv';
    const ENGLISH = 0;
    const FRENCH = 1;
    const ALPHA2 = 2;
    const ALPHA3 = 3;
    const NUMERIC = 4;

    public function load(ObjectManager $manager)
    {
        $fileInfo = new SplFileInfo(__DIR__.DIRECTORY_SEPARATOR.'csv'.DIRECTORY_SEPARATOR.self::CSV_FILE);

        if (!$fileInfo->isFile()) {
            throw new FileNotFoundException(sprintf('%s can not be found in csv subdirectory.', self::CSV_FILE));
        }

        if (!$fileInfo->isReadable()) {
            throw new FileNotFoundException(sprintf('%s in csv subdirectory is not readable.', self::CSV_FILE));
        }

        if (false !== ($csvFile = fopen($fileInfo, 'r'))) {
            while (false !== ($data = fgetcsv($csvFile, 512, ',', '"'))) {
                $country = new Country();
                $country->setAlpha2($data[self::ALPHA2]);
                $country->setAlpha3($data[self::ALPHA3]);
                $country->setEnglish($data[self::ENGLISH]);
                $country->setFrench($data[self::FRENCH]);
                $country->setNumeric($data[self::NUMERIC]);
                $this->addReference('country_'.$data[self::ALPHA2], $country);
                $manager->persist($country);
            }
        }

        $manager->flush();
    }
}
