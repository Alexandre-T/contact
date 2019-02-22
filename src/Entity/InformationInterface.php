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

use DateTime;

/**
 * Interface InformationInterface.
 *
 * @category Entity
 */
interface InformationInterface
{
    /**
     * Return date time creation.
     *
     * @return DateTime | null
     */
    public function getCreated(): ?DateTime;

    /**
     * Return creator (user entity).
     *
     * @return User | null
     */
    public function getCreator(): ?User;

    /**
     * Return date time of the last update.
     *
     * @return DateTime | null
     */
    public function getUpdated(): ?DateTime;
}
