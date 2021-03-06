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
use App\Entity\Service;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Service Manager.
 *
 * @category Manager
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license CeCILL-B V1
 */
class ServiceManager extends AbstractRepositoryManager implements ManagerInterface
{
    /**
     * Const for the alias query.
     */
    const ALIAS = 'service';

    /**
     * Return the main repository.
     *
     * @return EntityRepository
     */
    protected function getMainRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Service::class);
    }

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
        return self::ALIAS.'.name';
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
     * Get pagination for a class.
     *
     * @param array $search
     * @param int   $page
     * @param int   $limit
     *
     * @return PaginationInterface
     */
    public function search(array $search, int $page = 1, int $limit = self::LIMIT): PaginationInterface
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

        //TODO Add filter when region are not empty
        if (!empty($search['category'])) {
            $qb->innerJoin('p.category', 'c')
                ->andWhere('c.id = :id')
                ->setParameter('id', $search['category']);
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
                ->setParameter('france', 'FR')
            ;
        }

        $qb->getQuery();

        $pagination = $this->paginator->paginate($qb, $page, $limit);

        return $pagination;
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
            ->addSelect('service.familyName as HIDDEN family')
            ->addSelect('service.jobTitle as HIDDEN job');
    }
}
