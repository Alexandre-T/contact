<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Entity
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Entity;

/**
 * Entity Interface.
 *
 * @category Entity
 */
interface EntityInterface
{
    /**
     * Return the id or null if entity was never saved.
     *
     * @return int|null
     */
    public function getId(): ?int;

    public function setCreator(User $user): self;
}
