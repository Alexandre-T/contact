<?php
/**
 * This file is part of the contact Application.
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

use DateTimeInterface;

/**
 * Entity trait.
 * This trait implements Entity and information interfaces.
 */
trait EntityTrait
{
    /**
     * Creation datetime.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", name="ent_created", options={"comment":"Creation datetime"})
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * Entity creator.
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="usr_id")
     */
    private $creator;

    /**
     * Last update datetime.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", name="ent_updated", options={"comment":"Update datetime"})
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     * Creation date time getter.
     *
     * @return DateTimeInterface|null
     */
    public function getCreated(): ?DateTimeInterface
    {
        return $this->created;
    }

    /**
     * Last update date time getter.
     *
     * @return DateTimeInterface|null
     */
    public function getUpdated(): ?DateTimeInterface
    {
        return $this->updated;
    }

    /**
     * Creator getter.
     *
     * @return User|null
     */
    public function getCreator(): ?User
    {
        return $this->creator;
    }

    /**
     * Creator fluent setter.
     *
     * @param User|null $creator
     *
     * @return EntityInterface|EntityTrait
     */
    public function setCreator(?User $creator): EntityInterface
    {
        $this->creator = $creator;

        return $this;
    }
}
