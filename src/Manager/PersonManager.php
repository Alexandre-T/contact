<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Manager
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2017 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Manager;

use App\Entity\EntityInterface;
use App\Entity\Person;
use App\Entity\PostalAddress;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Person Manager.
 *
 * @category Manager
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license CeCILL-B V1
 */
class PersonManager extends AbstractRepositoryManager implements ManagerInterface
{
    /**
     * Const for the alias query.
     */
    const ALIAS = 'person';

    /**
     * Return default alias.
     */
    public function getDefaultAlias(): string
    {
        return self::ALIAS;
    }

    /**
     * Get the default field for ordering data.
     *
     * @return string
     */
    public function getDefaultSortField(): string
    {
        return self::ALIAS.'.familyName';
    }

    /**
     * Return the Query builder needed by the paginator.
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->repository->createQueryBuilder(self::ALIAS);
    }

    /**
     * Is this entity deletable?
     *
     * @param EntityInterface $entity
     *
     * @return bool true if entity is deletable
     */
    public function isDeletable(EntityInterface $entity): bool
    {
        return true;
    }

    /**
     * Create a new person.
     *
     * @return Person
     */
    public function createPerson(): Person
    {
        $person = new Person();
        $postalAddress = new PostalAddress();
        $person->setAddress($postalAddress);

        return $person;
    }

    /**
     * Get pagination for a class.
     *
     * @param array $search
     * @param int   $page
     * @param int   $limit
     *
     * @return PaginationInterface
     */
    public function search(?array $search = [], int $page = 1, int $limit = self::LIMIT): PaginationInterface
    {
        $qb = $this->repository->createQueryBuilder('p');

        if (!empty($search['search'])) {
            $data = "%{$search['search']}%";
            $qb->andWhere($qb->expr()->like('p.birthName', ':search'))
                ->orWhere($qb->expr()->like('p.email', ':search'))
                ->orWhere($qb->expr()->like('p.facebook', ':search'))
                ->orWhere($qb->expr()->like('p.familyName', ':search'))
                ->orWhere($qb->expr()->like('p.givenName', ':search'))
                ->orWhere($qb->expr()->like('p.instagram', ':search'))
                ->orWhere($qb->expr()->like('p.jobTitle', ':search'))
                ->orWhere($qb->expr()->like('p.linkedIn', ':search'))
                ->orWhere($qb->expr()->like('p.twitter', ':search'))
                ->orWhere($qb->expr()->like('p.url', ':search'))
                ->orWhere($qb->expr()->like('p.youtube', ':search'))
                ->setParameter('search', $data);
        }

        if (!empty($search['category'])) {
            $qb->innerJoin('p.category', 'c')
                ->andWhere('c.id = :id')
                ->setParameter('id', $search['category']);
        }

        if (!empty($search['thematic'])) {
            $qb->leftJoin('p.thematics', 't')
                ->andWhere('t.id = :thematic')
                ->setParameter('thematic', $search['thematic']);
        }

        if (!empty($search['region'])) {
            $qb->leftJoin('p.address', 'a')
                ->leftJoin('p.memberOf', 'm')
                ->leftJoin('m.address', 'ao')
                ->andWhere(
                    $qb->expr()->orX(
                        $qb->expr()->andX(
                            $qb->expr()->in('SUBSTRING(a.postalCode, 1, 2)', ':region'),
                            $qb->expr()->eq('a.country', ':france')
                        ),
                        $qb->expr()->andX(
                            $qb->expr()->in('SUBSTRING(ao.postalCode, 1, 2)', ':region'),
                            $qb->expr()->eq('ao.country', ':france')
                        )
                    )
                )
                ->setParameter('region', $this->getDepartments($search['region']))
                ->setParameter('france', 'FR');
        }
        if (!empty($search['department'])) {
            $qb->leftJoin('p.address', 'a')
                ->leftJoin('p.memberOf', 'm')
                ->leftJoin('m.address', 'ao')
                ->andWhere(
                    $qb->expr()->orX(
                        $qb->expr()->andX(
                            $qb->expr()->like('a.postalCode', ':department'),
                            $qb->expr()->eq('a.country', ':france')
                        ),
                        $qb->expr()->andX(
                            $qb->expr()->like('ao.postalCode', ':department'),
                            $qb->expr()->eq('ao.country', ':france')
                        )
                    )
                )
                ->setParameter('department', $search['department'].'%')
                ->setParameter('france', 'FR');
        }

        $qb->getQuery();

        $pagination = $this->paginator->paginate($qb, $page, $limit);

        return $pagination;
    }

    /**
     * @param $region
     *
     * @return array
     */
    private function getDepartments(string $region): array
    {
        switch ($region) {
            case 'FR-ARA':
                return ['01', '03', '07', '15', '26', '38', '42', '43', '63', '69', '73', '74'];
            case 'FR-BFC':
                return ['21', '25', '39', '58', '70', '71', '89', '90'];
            case 'FR-BRE':
                return ['22', '29', '35', '56'];
            case 'FR-CVL':
                return ['18', '28', '36', '37', '41', '45'];
            case 'FR-COR':
                return ['2A', '2B'];
            case 'FR-GES':
                return ['08', '10', '51', '52', '54', '55', '57', '67', '68', '88'];
            case 'FR-HDF':
                return ['02', '59', '60', '62', '80'];
            case 'FR-IDF':
                return ['75', '77', '78', '91', '92', '93', '94', '95'];
            case 'FR-NOR':
                return ['14', '27', '50', '61', '76'];
            case 'FR-NAQ':
                return ['16', '17', '19', '23', '24', '33', '40', '47', '64', '79', '86', '87'];
            case 'FR-OCC':
                return ['09', '11', '12', '30', '31', '32', '34', '46', '48', '65', '66', '81', '82'];
            case 'FR-PDL':
                return ['44', '49', '53', '72', '85'];
            case 'FR-PAC':
                return ['04', '05', '06', '13', '83', '84'];
            case 'FR-UMA':
                return ['97'];

            default:
                return ['00'];
        }
    }

    /**
     * Return the main repository.
     *
     * @return EntityRepository
     */
    protected function getMainRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Person::class);
    }

    /**
     * This method will add the HIDDEN field, the sortable field.
     *
     * @see https://github.com/KnpLabs/KnpPaginatorBundle/issues/196
     *
     * @param QueryBuilder $queryBuilder
     *
     * @return QueryBuilder
     */
    protected function addHiddenField(QueryBuilder $queryBuilder): QueryBuilder
    {
        return $queryBuilder
            ->addSelect('person.familyName as HIDDEN family')
            ->addSelect('person.jobTitle as HIDDEN job');
    }
}
