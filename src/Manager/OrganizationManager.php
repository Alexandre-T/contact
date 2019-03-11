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
use App\Entity\Organization;
use App\Entity\Person;
use App\Entity\PostalAddress;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;

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
     * Return the main repository.
     *
     * @return EntityRepository
     */
    protected function getMainRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Organization::class);
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
        $personRepository = $this->entityManager->getRepository(Person::class);

        return
            0 === $personRepository->count(['alumnus' => $entity]) &&
            0 === $personRepository->count(['memberOf' => $entity]);
    }

    /**
     * Create a new organization.
     *
     * @return Organization
     */
    public function createOrganization(): Organization
    {
        $organization = new Organization();
        $postalAddress = new PostalAddress();
        $organization->setAddress($postalAddress);

        return $organization;
    }

    /**
     * Get paginated contact from an organization.
     *
     * @param Organization $organization
     * @param int          $page
     * @param int          $limit
     *
     * @return PaginationInterface
     */
    public function getContacts(Organization $organization, int $page, int $limit): PaginationInterface
    {
        $personRepository = $this->entityManager->getRepository(Person::class);

        $qb = $personRepository->createQueryBuilder('p');
        $qb->where('p.memberOf = :organization')
            ->setParameter('organization', $organization);

        return $this->paginator->paginate($qb, $page, $limit);
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
