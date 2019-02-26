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
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Organization entity.
 *
 * @ORM\Entity(repositoryClass="App\Repository\OrganizationRepository")
 * @ORM\Table(
 *     name="te_organization",
 *     schema="data",
 *     options={"comment":"Organisations table", "charset":"utf8mb4","collate":"utf8mb4_unicode_ci"},
 *     indexes={
 *          @ORM\Index(name="ndx_organization_creator", columns={"creator_id"}),
 *          @ORM\Index(name="ndx_organization_label", columns={"org_legal"})
 *     },
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="uk_organization_label", columns={"org_label"})
 *     }
 * )
 * @Gedmo\Loggable
 *
 * @UniqueEntity("label", message="error.organization.label.unique")
 */
class Organization implements EntityInterface, InformationInterface
{
    use EntityTrait;

    /**
     * Identifier.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer", name="org_id", options={"unsigned":true, "comment":"Identifier"})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Acronym definition.
     *
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, name="org_acronyme", options={"comment":"Acronym definition"})
     *
     * @Gedmo\Versioned
     */
    private $acronymDefinition;

    /**
     * Creation datetime.
     *
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="org_created", options={"comment":"Creation datetime"})
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * User creator.
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="usr_id")
     */
    private $creator;

    /**
     * Organization label.
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="2")
     * @Assert\Length(max="255")
     *
     * @ORM\Column(type="string", length=255, name="org_label", options={"comment":"Organization label"})
     *
     * @Gedmo\Versioned
     */
    private $label;

    /**
     * Organization legal name.
     *
     * @var string
     *
     * @Assert\Length(max="255")
     *
     * @ORM\Column(type="string", length=255, name="org_legal", nullable=true, options={"comment":"Legal name organization"})
     */
    private $legalName;

    /**
     * Last update datetime.
     *
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="org_updated", options={"comment":"Update datetime"})
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

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
     *
     * @return Organization
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Acronym definition getter.
     *
     * @return string|null
     */
    public function getAcronymDefinition(): ?string
    {
        return $this->acronymDefinition;
    }

    /**
     * Acronym definition fluent setter.
     *
     * @param string|null $acronymDefinition
     *
     * @return Organization
     */
    public function setAcronymDefinition(?string $acronymDefinition): self
    {
        $this->acronymDefinition = $acronymDefinition;

        return $this;
    }

    /**
     * Legal name getter.
     *
     * @return string|null
     */
    public function getLegalName(): ?string
    {
        return $this->legalName;
    }

    /**
     * Legal name fluent setter.
     *
     * @param string|null $legalName
     *
     * @return Organization
     */
    public function setLegalName(?string $legalName): self
    {
        $this->legalName = $legalName;

        return $this;
    }
}
