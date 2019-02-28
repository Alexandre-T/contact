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

use DateTimeInterface;
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
 *          @ORM\Index(name="ndx_person_birthCountry", columns={"birthCountry_id"}),
 *          @ORM\Index(name="ndx_person_birthName", columns={"per_birthName", "per_givenName"}),
 *          @ORM\Index(name="ndx_person_creator", columns={"creator_id"}),
 *          @ORM\Index(name="ndx_person_familyName", columns={"per_familyName", "per_givenName"}),
 *          @ORM\Index(name="ndx_person_member", columns={"organization_id"})
 *     },
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="uk_person_address", columns={"address_id"})
 *     }
 * )
 *
 * @Gedmo\Loggable
 */
class Person implements EntityInterface, InformationInterface
{
    use EntityTrait;

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

    //TODO add these columns : Tel, Smartphone
    //TODO add as trait Facebook, Instagram, LinkedIn, Twitter

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
     * Creation datetime.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", name="per_created", options={"comment":"Creation datetime"})
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * User creator.
     *
     * FIXME move these properties to Trait!
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="usr_id")
     */
    private $creator;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="members")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="org_id")
     *
     * @Gedmo\Versioned()
     */
    private $memberOf;

    /**
     * National country.
     *
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Country")
     * @ORM\JoinColumn(name="birthCountry_id", referencedColumnName="cou_id", nullable=false)
     *
     * @Gedmo\Versioned()
     */
    private $nationality;

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
     * Last update datetime.
     *
     * FIXME move this to entity trait too and accept name as ent_updated.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", name="org_updated", options={"comment":"Update datetime"})
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

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
     * @return Country|null
     */
    public function getNationality(): ?Country
    {
        return $this->nationality;
    }

    /**
     * Nationality fluent setter.
     *
     * @param Country|null $nationality
     *
     * @return Person
     */
    public function setNationality(?Country $nationality): self
    {
        $this->nationality = $nationality;

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
}
