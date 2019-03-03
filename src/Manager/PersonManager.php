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
use App\Entity\InformationInterface;
use App\Entity\Person;
use App\Entity\PostalAddress;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Gedmo\Loggable\Entity\LogEntry;
use Gedmo\Loggable\Entity\Repository\LogEntryRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

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
     * Entity manager.
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * Knp Paginator.
     *
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * Repository.
     *
     * @var PersonRepository
     */
    protected $repository;

    /**
     * Log repository.
     *
     * @var LogEntryRepository
     */
    private $logRepository;

    /**
     * PersonManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param PaginatorInterface     $paginator
     */
    public function __construct(EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
        $this->repository = $this->entityManager->getRepository(Person::class);
        $this->logRepository = $this->entityManager->getRepository(LogEntry::class);
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
     * Retrieve logs of the axe.
     *
     * @param InformationInterface $entity
     *
     * @return LogEntry[]
     */
    public function retrieveLogs($entity): array
    {
        if (empty($entity)) {
            return [];
        }

        return $this->logRepository->getLogEntries($entity);
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

        //TODO Add filter when rubric and dpt and region are not empty
        if (!empty($search['category'])) {
            $qb->innerJoin('p.category', 'c')
                ->andWhere('c.id = :id')
                ->setParameter('id', $search['category']);
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
            ->addSelect('person.familyName as HIDDEN family')
            ->addSelect('person.jobTitle as HIDDEN job');
    }
}
