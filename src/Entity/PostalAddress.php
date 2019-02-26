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
 * Postal address entity.
 *
 * @ORM\Entity(repositoryClass="App\Repository\PostalAddressRepository")
 * @ORM\Table(
 *     name="te_postal",
 *     schema="data",
 *     options={"comment":"Postal adresses table","charset":"utf8mb4","collate":"utf8mb4_unicode_ci"},
 *     indexes={
 *          @ORM\Index(name="ndx_postal_code", columns={"pad_code"}),
 *          @ORM\Index(name="ndx_postal_country", columns={"country_id"}),
 *          @ORM\Index(name="ndx_postal_locality", columns={"pad_locality"}),
 *     }
 * )
 *
 * @Gedmo\Loggable
 */
class PostalAddress implements EntityInterface, InformationInterface
{
    use EntityTrait;
    /**
     * Postal identifier.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer", name="pad_id", options={"unsigned":true, "comment":"Postal address identifier"})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Country.
     *
     * @var Country
     *
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="Country",fetch="EAGER")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="cou_id")
     *
     * @Gedmo\Versioned
     */
    private $country;

    /**
     * Locality.
     *
     * @Assert\Length(max="255")
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="pad_locality", options={"comment":"Locality"})
     */
    private $locality;

    /**
     * Post Office Box Number.
     *
     * @Assert\Length(max="32")
     *
     * @ORM\Column(type="string", length=32, nullable=true, name="pad_box", options={"comment":"Post office box number"})
     *
     * @Gedmo\Versioned
     */
    private $postOfficeBoxNumber;

    /**
     * Postal code.
     *
     * @Assert\Length(max="5")
     *
     * @ORM\Column(type="string", length=5, nullable=true, name="pad_code", options={"comment":"Postal code"})
     *
     * @Gedmo\Versioned
     */
    private $postalCode;

    /**
     * Street address.
     *
     * @Assert\Length(max="255")
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="pad_street", options={"comment":"Complete treet address"})
     *
     * @Gedmo\Versioned
     */
    private $streetAddress;

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
     * Country getter.
     *
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * Country fluent setter.
     *
     * @param Country $country
     *
     * @return PostalAddress
     */
    public function setCountry(Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Locality getter.
     *
     * @return string|null
     */
    public function getLocality(): ?string
    {
        return $this->locality;
    }

    /**
     * Locality fluent setter.
     *
     * @param string|null $locality
     *
     * @return PostalAddress
     */
    public function setLocality(?string $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Post office box number getter.
     *
     * @return string|null
     */
    public function getPostOfficeBoxNumber(): ?string
    {
        return $this->postOfficeBoxNumber;
    }

    /**
     * Post office box number fluent setter.
     *
     * @param string $postOfficeBoxNumber
     *
     * @return PostalAddress
     */
    public function setPostOfficeBoxNumber(string $postOfficeBoxNumber): self
    {
        $this->postOfficeBoxNumber = $postOfficeBoxNumber;

        return $this;
    }

    /**
     * Postal code getter.
     *
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Postal code fluent setter.
     *
     * @param string|null $postalCode
     *
     * @return PostalAddress
     */
    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Street address getter.
     *
     * @return string|null
     */
    public function getStreetAddress(): ?string
    {
        return $this->streetAddress;
    }

    /**
     * Street address fluent setter.
     *
     * @param string|null $streetAddress
     *
     * @return PostalAddress
     */
    public function setStreetAddress(?string $streetAddress): self
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }
}
