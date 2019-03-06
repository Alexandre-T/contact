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
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Person entity.
 *
 * This is the contacts of Organization.
 *
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 * @ORM\Table(
 *     name="te_person",
 *     schema="data",
 *     options={"comment":"Contact table", "charset":"utf8mb4","collate":"utf8mb4_unicode_ci"},
 *     indexes={
 *          @ORM\Index(name="ndx_person_alumni", columns={"school_id"}),
 *          @ORM\Index(name="ndx_person_birthCountry", columns={"per_nationality"}),
 *          @ORM\Index(name="ndx_person_birthName", columns={"per_birthName", "per_givenName"}),
 *          @ORM\Index(name="ndx_person_category", columns={"category_id"}),
 *          @ORM\Index(name="ndx_person_creator", columns={"creator_id"}),
 *          @ORM\Index(name="ndx_person_familyName", columns={"per_familyName", "per_givenName"}),
 *          @ORM\Index(name="ndx_person_member", columns={"organization_id"}),
 *          @ORM\Index(name="ndx_person_service", columns={"service_id"})
 *     },
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="uk_person_address", columns={"address_id"})
 *     }
 * )
 *
 * @Gedmo\Loggable
 */
class Person implements EntityInterface, InformationInterface, SocialInterface
{
    use EntityTrait;
    use SocialTrait;

    /**
     * Gender constants.
     */
    const FEMALE = 1;
    const MALE = 2;
    const OTHER = 3;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Postal address.
     *
     * @var PostalAddress
     *
     * @ORM\OneToOne(targetEntity="App\Entity\PostalAddress", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="pad_id", onDelete="CASCADE", unique=true)
     */
    private $address;

    /**
     * Alumnus.
     *
     * (Ancien élève).
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="alumni")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="org_id")
     *
     * @Gedmo\Versioned()
     */
    private $alumnus;

    /**
     * Birth name.
     *
     * @var string
     *
     * @Assert\Length(max="32")
     *
     * @ORM\Column(type="string", length=32, nullable=true, name="per_birthName", options={"comment":"Birth name"})
     *
     * @Gedmo\Versioned()
     */
    private $birthName;

    /**
     * Email of person.
     *
     * @var string
     *
     * @Assert\Length(max="255")
     * @Assert\Email()
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="per_email", options={"comment":"Email"})
     *
     * @Gedmo\Versioned()
     */
    private $email;

    /**
     * Family used name.
     *
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Length(max="32")
     *
     * @ORM\Column(type="string", length=32, name="per_familyName", options={"comment":"Family and usage name"})
     *
     * @Gedmo\Versioned()
     */
    private $familyName;

    /**
     * Gender.
     *
     * @var int
     *
     * @Assert\Choice(callback="getGenders", message="form.person.error.gender")
     *
     * @ORM\Column(type="smallint", nullable=true, name="per_gender", options={"comment": "Gender 1 for male, 2 for female, 3 for others."})
     *
     * @Gedmo\Versioned()
     */
    private $gender;

    /**
     * Given name.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=32, nullable=true, name="per_givenName", options={"comment":"Given name"})
     *
     * @Gedmo\Versioned()
     */
    private $givenName;

    /**
     * Job title.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="per_jobTitle", options={"comment":"Job title"})
     *
     * @Gedmo\Versioned()
     */
    private $jobTitle;

    /**
     * Member of organization.
     *
     * @var Organization
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="members", fetch="EAGER")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="org_id")
     *
     * @Gedmo\Versioned()
     */
    private $memberOf;

    /**
     * National country.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=2, name="per_nationality", nullable=true, options={"comment":"Nationality alpha2 code"})
     *
     * @Gedmo\Versioned()
     */
    private $nationality;

    /**
     * Smartphone number.
     *
     * @Assert\Length(max="20")
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     *
     * @Gedmo\Versioned()
     */
    private $smartphone;

    /**
     * Telephone number.
     *
     * @Assert\Length(max="20")
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     *
     * @Gedmo\Versioned()
     */
    private $telephone;

    /**
     * Website contact.
     *
     * @Assert\Url()
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Gedmo\Versioned()
     */
    private $url;

    /**
     * Category.
     *
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="people", fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="cat_id", nullable=false)
     */
    private $category;

    /**
     * Service.
     *
     * @var Service
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="people", fetch="EAGER")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="ser_id", nullable=true)
     *
     * @Gedmo\Versioned
     */
    private $service;

    /**
     * Return available genders.
     *
     * This function is used by Assert\Choice callback.
     *
     * @return array
     */
    public static function getGenders(): array
    {
        return [
            self::FEMALE,
            self::MALE,
            self::OTHER,
        ];
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
     * Gender getter.
     *
     * @return int|null
     */
    public function getGender(): ?int
    {
        return $this->gender;
    }

    /**
     * Gender fluent setter.
     *
     * @param int|null $gender
     *
     * @return Person
     */
    public function setGender(?int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Postal address getter.
     *
     * @return PostalAddress|null
     */
    public function getAddress(): ?PostalAddress
    {
        return $this->address;
    }

    /**
     * Postal address fluent setter.
     *
     * @param PostalAddress|null $address
     *
     * @return Person
     */
    public function setAddress(?PostalAddress $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Alumnus getter.
     *
     * @return Organization|null
     */
    public function getAlumnus(): ?Organization
    {
        return $this->alumnus;
    }

    /**
     * Alumnus fluent setter.
     *
     * @param Organization|null $alumnus
     *
     * @return Person
     */
    public function setAlumnus(?Organization $alumnus): self
    {
        $this->alumnus = $alumnus;

        return $this;
    }

    /**
     * Email getter.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Email setter.
     *
     * @param string|null $email
     *
     * @return Person
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Job title getter.
     *
     * @return string|null
     */
    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    /**
     * Job title fluent setter.
     *
     * @param string|null $jobTitle
     *
     * @return Person
     */
    public function setJobTitle(?string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * Nationality getter.
     *
     * @return string|null
     */
    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    /**
     * Nationality fluent setter.
     *
     * @param string|null $nationality
     *
     * @return Person
     */
    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Smartphone getter.
     *
     * @return string|null
     */
    public function getSmartphone(): ?string
    {
        return $this->smartphone;
    }

    /**
     * Smartphone fluent setter.
     *
     * @param string|null $smartphone
     *
     * @return Person
     */
    public function setSmartphone(?string $smartphone): self
    {
        $this->smartphone = $smartphone;

        return $this;
    }

    /**
     * Telephone getter.
     *
     * @return string|null
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * Telephone fluent setter.
     *
     * @param string|null $telephone
     *
     * @return Person
     */
    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Url getter.
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Url fluent setter.
     *
     * @param string|null $url
     *
     * @return Person
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Organization getter.
     *
     * @return Organization|null
     */
    public function getMemberOf(): ?Organization
    {
        return $this->memberOf;
    }

    /**
     * Organization fluent setter.
     *
     * @param Organization|null $memberOf
     *
     * @return Person
     */
    public function setMemberOf(?Organization $memberOf): self
    {
        $this->memberOf = $memberOf;

        return $this;
    }

    /**
     * Return name.
     *
     * @return string|null name of person
     */
    public function getLabel(): ?string
    {
        if (is_null($this->getGivenName()) && is_null($this->getBirthName()) && is_null($this->getFamilyName())) {
            return null;
        }

        $result = $this->getGivenName() ?? '';

        if (empty($this->getBirthName()) || $this->getBirthName() === $this->getFamilyName()) {
            return $result.' '.$this->getFamilyName();
        }

        return "$result {$this->getFamilyName()} ({$this->getBirthName()})";
    }

    /**
     * Given name getter.
     *
     * @return string|null
     */
    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    /**
     * Given name fluent setter.
     *
     * @param string|null $givenName
     *
     * @return Person
     */
    public function setGivenName(?string $givenName): self
    {
        $this->givenName = $givenName;

        return $this;
    }

    /**
     * Birth name getter.
     *
     * @return string|null
     */
    public function getBirthName(): ?string
    {
        return $this->birthName;
    }

    /**
     * Birth name fluent setter.
     *
     * @param string|null $birthName
     *
     * @return Person
     */
    public function setBirthName(?string $birthName): self
    {
        $this->birthName = $birthName;

        return $this;
    }

    /**
     * Family name getter.
     *
     * @return string|null
     */
    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    /**
     * Family name fluent setter.
     *
     * @param string $familyName
     *
     * @return Person
     */
    public function setFamilyName(string $familyName): self
    {
        $this->familyName = $familyName;

        return $this;
    }

    /**
     * Category getter.
     *
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Category fluent setter.
     *
     * @param Category|null $category
     *
     * @return Person
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Service getter.
     *
     * @return Service|null
     */
    public function getService(): ?Service
    {
        return $this->service;
    }

    /**
     * Service fluent setter.
     *
     * @param Service|null $service
     *
     * @return Person
     */
    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }
}
