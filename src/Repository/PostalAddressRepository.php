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

use App\Entity\PostalAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Postal address repository.
 *
 * @method PostalAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostalAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostalAddress[]    findAll()
 * @method PostalAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostalAddressRepository extends ServiceEntityRepository
{
    /**
     * Postal address repository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PostalAddress::class);
    }

    /**
     * Find by french departments.
     *
     * @param int $department
     *
     * @return PostalAddress[] Returns an array of Country objects
     */
    public function findByFrenchDepartment(int $department)
    {
        //Dpt with two or three digits.
        $sDpt = sprintf('%02d', $department).'%';
        $qb = $this->createQueryBuilder('p');

        return $qb->andWhere('p.country = :country')
            ->andWhere($qb->expr()->like('p.postalCode', ':department'))
            ->setParameter('country', 'FR')
            ->setParameter('department', $sDpt)
            ->orderBy('p.locality', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
