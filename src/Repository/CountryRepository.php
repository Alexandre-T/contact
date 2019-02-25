<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Repository
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Country repository.
 *
 * @method Country|null find($id, $lockMode = null, $lockVersion = null)
 * @method Country|null findOneBy(array $criteria, array $orderBy = null)
 * @method Country[]    findAll()
 * @method Country[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Country::class);
    }

    /**
     * Find country where english name is beginning with $value.
     *
     * @param string $value
     *
     * @return Country[] Returns an array of Country objects
     */
    public function findByEnglishFirstLetters(string $value)
    {
        $value .= '%';

        $qb = $this->createQueryBuilder('c');

        return $qb->andWhere($qb->expr()->like('c.english', ':val'))
            ->setParameter('val', "$value")
            ->orderBy('c.english', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find country where french name is beginning with $value.
     *
     * @param string $value
     *
     * @return Country[] Returns an array of Country objects
     */
    public function findByFrenchFirstLetters(string $value)
    {
        $value .= '%';

        $qb = $this->createQueryBuilder('c');

        return $qb->andWhere($qb->expr()->like('c.french', ':val'))
            ->setParameter('val', "$value")
            ->orderBy('c.french', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Return country by alpha2 code.
     *
     * @param string $value
     *
     * @return Country|null
     */
    public function findOneByCode(string $value): ?Country
    {
        return $this->findOneBy(['alpha2' => $value]);
    }
}
