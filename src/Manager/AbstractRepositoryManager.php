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
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Abstract manager class.
 *
 * Provides useful function for main repository.
 *
 * @property EntityManagerInterface entityManager
 * @property EntityRepository repository
 * @property PaginatorInterface paginator
 */
abstract class AbstractRepositoryManager implements ManagerInterface
{
    /**
     * Return the number of current entities registered in database.
     *
     * @param array $criteria
     * @return int
     */
    public function count(array $criteria = []): int
    {
        return $this->repository->count($criteria);
    }

    /**
     * Delete entity without verification.
     *
     * @param EntityInterface $entity
     */
    public function delete(EntityInterface $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * Return default alias.
     */
    abstract public function getDefaultAlias(): string;

    /**
     * Get pagination for a class.
     *
     * @param int $page
     * @param int $limit
     * @param string|null $sortField
     * @param string $sortOrder
     * @return PaginationInterface
     */
    public function paginate(int $page = 1, int $limit = self::LIMIT, string $sortField = null, $sortOrder = self::SORT): PaginationInterface
    {
        $sortField = $sortField ?? $this->getDefaultSortField();

        $queryBuilder = $this->repository->createQueryBuilder($this->getDefaultAlias());

        return $this->paginator->paginate(
            $queryBuilder,
            $page,
            $limit,
            ['defaultSortFieldName' => $sortField, 'defaultSortDirection' => $sortOrder == 'DESC'?'DESC':'ASC']
        );
    }

    /**
     * Get pagination with criteria for a class.
     *
     * @param Criteria $criteria
     * @param int $page
     * @param int $limit
     * @param string|null $sortField
     * @param string $sortOrder
     * @return PaginationInterface
     *
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function paginateWithCriteria(Criteria $criteria, int $page = 1, int $limit = self::LIMIT,  string $sortField = null, $sortOrder = self::SORT): PaginationInterface
    {
        $queryBuilder = $this->repository->createQueryBuilder($this->getDefaultAlias());
        $queryBuilder->addCriteria($criteria);

        return $this->paginator->paginate(
            $queryBuilder,
            $page,
            $limit,
            ['defaultSortFieldName' => $this->getDefaultSortField(), 'defaultSortDirection' => $sort == 'ASC'?$sort:'DESC']
        );
    }

    /**
     * Save new or modified User.
     *
     * @param EntityInterface $entity
     */
    public function save(EntityInterface $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}