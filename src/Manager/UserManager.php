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

use App\Bean\Factory\LogFactory;
use App\Entity\EntityInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Gedmo\Loggable\Entity\LogEntry;
use Gedmo\Loggable\Entity\Repository\LogEntryRepository;
use Knp\Component\Pager\PaginatorInterface;

/**
 * User Manager.
 *
 * @category Manager
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license CeCILL-B V1
 */
// FIXME implements all interfaces
class UserManager extends AbstractRepositoryManager implements ManagerInterface //, LoggableManagerInterface
{
    /**
     * Const for the alias query.
     */
    const ALIAS = 'user';

    /**
     * Entity manager.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Knp Paginator.
     *
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * Repository.
     *
     * @var UserRepository
     */
    protected $repository;

    /**
     * Log repository.
     *
     * @var LogEntryRepository
     */
    private $logRepository;

    /**
     * UserManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param PaginatorInterface $paginator
     */
    public function __construct(EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
        $this->repository = $this->entityManager->getRepository(User::class);
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
        return self::ALIAS . '.label';
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
     * @return bool true if entity is deletable
     */
    public function isDeletable(EntityInterface $entity): bool
    {
        //FIXME We cannot delete a user which have create an object.
        return false;
    }

    /**
     * Retrieve logs of the axe.
     *
     * @param User $entity
     *
     * @return LogEntry[]
     */
    public function retrieveLogs($entity): array
    {
        return $this->logRepository->getLogEntries($entity);

        //return LogFactory::createUserLogs($logs);
    }
}
