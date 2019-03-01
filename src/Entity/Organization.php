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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
 *          @ORM\UniqueConstraint(name="uk_organization_label", columns={"org_label"}),
 *          @ORM\UniqueConstraint(name="uk_organization_address", columns={"address_id"})
 *     }
 * )
 * @Gedmo\Loggable
 *
 * @UniqueEntity("label", message="error.organization.label.unique")
 */
class Organization implements EntityInterface, InformationInterface, SocialInterface
{
    use SocialTrait;
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
     * Postal address.
     *
     * @var PostalAddress
     *
     * @ORM\OneToOne(targetEntity="PostalAddress",cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="pad_id", onDelete="CASCADE", unique=true)
     */
    private $address;

    /**
     * Organization label.
     *
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Length(min="2")
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
     *
     * @Gedmo\Versioned
     */
    private $legalName;

    /**
     * Alumni.
     *
     * (Anciens élèves)
     *
     * @var Person[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Person", mappedBy="alumnus")
     */
    private $alumni;

    /**
     * Members of this organization.
     *
     * @var Person[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Person", mappedBy="memberOf")
     */
    private $members;

    /**
     * Organization constructor.
     */
    public function __construct()
    {
        $this->alumni = new ArrayCollection();
        $this->members = new ArrayCollection();
    }

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
    public function setLabel($label): self
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
     * Address getter.
     *
     * @return PostalAddress
     */
    public function getAddress(): ?PostalAddress
    {
        return $this->address;
    }

    /**
     * Address fluent setter.
     *
     * @param PostalAddress $address
     *
     * @return Organization
     */
    public function setAddress(PostalAddress $address): Organization
    {
        $this->address = $address;

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

    /**
     * Alumni getter.
     *
     * @return Collection|Person[]
     */
    public function getAlumni(): Collection
    {
        return $this->alumni;
    }

    /**
     * Add an alumnus.
     *
     * @param Person $alumnus
     *
     * @return Organization
     */
    public function addAlumnus(Person $alumnus): self
    {
        if (!$this->alumni->contains($alumnus)) {
            $this->alumni[] = $alumnus;
            $alumnus->setAlumnus($this);
        }

        return $this;
    }

    /**
     * Remove an alumnus.
     *
     * @param Person $alumnus
     *
     * @return Organization
     */
    public function removeAlumnus(Person $alumnus): self
    {
        if ($this->alumni->contains($alumnus)) {
            $this->alumni->removeElement($alumnus);
            // set the owning side to null (unless already changed)
            if ($alumnus->getAlumnus() === $this) {
                $alumnus->setAlumnus(null);
            }
        }

        return $this;
    }

    /**
     * Members getter.
     *
     * @return Collection|Person[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    /**
     * Add an member of organization.
     *
     * @param Person $memberOf
     *
     * @return Organization
     */
    public function addMemberOf(Person $memberOf): self
    {
        if (!$this->members->contains($memberOf)) {
            $this->members[] = $memberOf;
            $memberOf->setMemberOf($this);
        }

        return $this;
    }

    /**
     * Remove an memberOf.
     *
     * @param Person $memberOf
     *
     * @return Organization
     */
    public function removeMemberOf(Person $memberOf): self
    {
        if ($this->members->contains($memberOf)) {
            $this->members->removeElement($memberOf);
            // set the owning side to null (unless already changed)
            if ($memberOf->getMemberOf() === $this) {
                $memberOf->setMemberOf(null);
            }
        }

        return $this;
    }
}
