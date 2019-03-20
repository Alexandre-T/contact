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

use Doctrine\ORM\Mapping as ORM;

/**
 * Thematic entity.
 *
 * This is the thematics of Person.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ThematicRepository")
 * @ORM\Table(
 *     name="tr_thematic",
 *     schema="data",
 *     options={"comment":"Thematic resource table", "charset":"utf8mb4","collate":"utf8mb4_unicode_ci"},
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="uk_thematic_code", columns={"the_code"}),
 *          @ORM\UniqueConstraint(name="uk_thematic_label", columns={"the_label"})
 *     }
 * )
 */
class Thematic
{
    /**
     * Identifier.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Code.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=5, name="the_code")
     */
    private $code;

    /**
     * Label.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=1024, name="the_label")
     */
    private $label;

    /**
     * Identifier getter.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Code getter.
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Code fluent setter.
     *
     * @param string $code
     * @return Thematic
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Label getter.
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Label fluent setter.
     *
     * @param string $label
     * @return Thematic
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
