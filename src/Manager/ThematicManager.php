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

use App\Entity\Thematic;
use App\Repository\ThematicRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Thematic Manager.
 *
 * @category Manager
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license CeCILL-B V1
 */
class ThematicManager
{
    /**
     * Entity manager interface.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Repository.
     *
     * @var ThematicRepository
     */
    private $repository;

    /**
     * ThematicManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->getMainRepository();
    }

    /**
     * Retrieve all Thematic.
     *
     * @return Thematic[]
     */
    public function retrieveAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Return the main repository.
     *
     * @return ThematicRepository
     */
    protected function getMainRepository(): ThematicRepository
    {
        return $this->entityManager->getRepository(Thematic::class);
    }
}
