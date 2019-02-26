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
 * Country entity.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 * @ORM\Table(
 *     name="tr_country",
 *     schema="data",
 *     options={"comment":"Country ressource table","charset":"utf8mb4","collate":"utf8mb4_unicode_ci"},
 *     indexes={
 *          @ORM\Index(name="ndx_country_english", columns={"cou_english"}),
 *          @ORM\Index(name="ndx_country_french", columns={"cou_french"}),
 *     },
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="uk_country_alpha2", columns={"cou_alpha2"}),
 *          @ORM\UniqueConstraint(name="uk_country_alpha3", columns={"cou_alpha3"}),
 *          @ORM\UniqueConstraint(name="uk_country_numeric", columns={"cou_numeric"})
 *     }
 * )
 */
class Country
{
    const FRANCE = 'FR';

    /**
     * Country identifier.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="cou_id", options={"unsigned":true, "comment":"Country internal identifier"})
     */
    private $id;

    /**
     * Alpha2 Identifier.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=2, unique=true, name="cou_alpha2", options={"comment":"Alpha2 code"})
     */
    private $alpha2 = 'WW';

    /**
     * Alpha3 Identifier.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=3, unique=true, name="cou_alpha3", options={"comment":"Alpha3 code"})
     */
    private $alpha3 = 'WWW';

    /**
     * English name.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, name="cou_english", options={"comment":"English name"})
     */
    private $english = 'Not available';

    /**
     * French name.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, name="cou_french", options={"comment":"French name"})
     */
    private $french = 'Non disponible';

    /**
     * Numeric identifier.
     *
     * @ORM\Column(type="smallint", name="cou_numeric", options={"comment":"Numeric code"})
     */
    private $numeric = 0;

    /**
     * Id getter.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Alpha2 getter.
     *
     * @return string
     */
    public function getAlpha2(): string
    {
        return $this->alpha2;
    }

    /**
     * Alpha2 setter.
     *
     * @param string $alpha2
     *
     * @return Country
     */
    public function setAlpha2(string $alpha2): self
    {
        $this->alpha2 = $alpha2;

        return $this;
    }

    /**
     * Alpha3 getter.
     *
     * @return string
     */
    public function getAlpha3(): string
    {
        return $this->alpha3;
    }

    /**
     * Alpha3 setter.
     *
     * @param string $alpha3
     *
     * @return Country
     */
    public function setAlpha3(string $alpha3): self
    {
        $this->alpha3 = $alpha3;

        return $this;
    }

    /**
     * English name getter.
     *
     * @return string
     */
    public function getEnglish(): string
    {
        return $this->english;
    }

    /**
     * English name setter.
     *
     * @param string $english
     *
     * @return Country
     */
    public function setEnglish(string $english): self
    {
        $this->english = $english;

        return $this;
    }

    /**
     * French name getter.
     *
     * @return string
     */
    public function getFrench(): string
    {
        return $this->french;
    }

    /**
     * French name setter.
     *
     * @param string $french
     *
     * @return Country
     */
    public function setFrench(string $french): self
    {
        $this->french = $french;

        return $this;
    }

    /**
     * Numeric code getter.
     *
     * @return int
     */
    public function getNumeric(): int
    {
        return $this->numeric;
    }

    /**
     * Numeric code setter.
     *
     * @param int $numeric
     *
     * @return Country
     */
    public function setNumeric(int $numeric): self
    {
        $this->numeric = $numeric;

        return $this;
    }
}
