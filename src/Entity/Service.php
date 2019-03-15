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
 * Service entity.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 * @ORM\Table(
 *     name="te_service",
 *     schema="data",
 *     indexes={
 *          @ORM\Index(name="ndx_service_creator", columns={"creator_id"}),
 *          @ORM\Index(name="ndx_service_organization", columns={"organization_id"})
 *     },
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="uk_service_name", columns={"ser_name"})
 *     }
 * )
 *
 * @Gedmo\Loggable
 *
 * @UniqueEntity("label", message="error.service.name.unique")
 */
class Service implements EntityInterface, InformationInterface
{
    use EntityTrait;

    /**
     * Identifier.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="ser_id", options={"comment": "Service identifier"})
     */
    private $id;

    /**
     * Name of service.
     *
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Length(max="64")
     *
     * @ORM\Column(type="string", length=64, name="ser_name", options={"comment": "Service name"})
     *
     * @Gedmo\Versioned
     */
    private $name;

    /**
     * Organization.
     *
     * @var Organization
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="services", fetch="EAGER")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="org_id", nullable=false)
     */
    private $organization;

    /**
     * Members of this service.
     *
     * @var Collection|Person[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Person", mappedBy="service")
     */
    private $people;

    /**
     * Service constructor.
     */
    public function __construct()
    {
        $this->people = new ArrayCollection();
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
     * Return the service label.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getName()??'';
    }

    /**
     * Name getter.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Name fluent setter.
     *
     * @param string $name
     *
     * @return Service
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Organization getter.
     *
     * @return Organization|null
     */
    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    /**
     * Organization fluent setter.
     *
     * @param Organization|null $organization
     *
     * @return Service
     */
    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * People getter.
     *
     * @return Collection|Person[]
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    /**
     * Person fluent adder.
     *
     * @param Person $person
     *
     * @return Service
     */
    public function addPerson(Person $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people[] = $person;
            $person->setService($this);
        }

        return $this;
    }

    /**
     * Person fluent remover.
     *
     * @param Person $person
     *
     * @return Service
     */
    public function removePerson(Person $person): self
    {
        if ($this->people->contains($person)) {
            $this->people->removeElement($person);
            // set the owning side to null (unless already changed)
            if ($person->getService() === $this) {
                $person->setService(null);
            }
        }

        return $this;
    }

    /**
     * Return name of service.
     *
     * @return string|null
     */
    public function __toString(): ?string
    {
        return $this->getName();
    }
}
