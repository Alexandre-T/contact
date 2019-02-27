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

use App\Entity\Country;
use App\Entity\EntityInterface;
use App\Entity\InformationInterface;
use App\Entity\Organization;
use App\Entity\PostalAddress;
use App\Repository\CountryRepository;
use App\Repository\OrganizationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Gedmo\Loggable\Entity\LogEntry;
use Gedmo\Loggable\Entity\Repository\LogEntryRepository;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Organization Manager.
 *
 * @category Manager
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license CeCILL-B V1
 */
class OrganizationManager extends AbstractRepositoryManager implements ManagerInterface
{
    /**
     * Const for the alias query.
     */
    const ALIAS = 'organization';

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
     * @var OrganizationRepository
     */
    protected $repository;

    /**
     * Log repository.
     *
     * @var LogEntryRepository
     */
    private $logRepository;

    /**
     * Country repository.
     *
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * OrganizationManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param PaginatorInterface     $paginator
     */
    public function __construct(EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
        $this->repository = $this->entityManager->getRepository(Organization::class);
        $this->countryRepository = $this->entityManager->getRepository(Country::class);
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
        return self::ALIAS.'.label';
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
        //return 0 === $this->repository->count(['creator' => $entity]);
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
        return $this->logRepository->getLogEntries($entity);
    }

    /**
     * Create a new organization.
     *
     * @param string $code
     *
     * @return Organization
     */
    public function createOrganization($code = 'FR'): Organization
    {
        $organization = new Organization();
        $postalAddress = new PostalAddress();
        $france = $this->countryRepository->findOneByCode($code);
        if ($france) {
            $postalAddress->setCountry($france);
        }
        $organization->setAddress($postalAddress);

        return $organization;
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
            ->addSelect('organization.legalName as HIDDEN legal')
            ->addSelect('organization.label as HIDDEN label');
    }
}