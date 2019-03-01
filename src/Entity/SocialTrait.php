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

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Social Trait implements Social network interface.
 */
trait SocialTrait
{
    /**
     * Facebook account.
     *
     * @var string
     *
     * @Assert\Length(max=64)
     *
     * @ORM\Column(type="string", length=64, name="sn_facebook", nullable=true, options={"comment":"Facebook account"})
     *
     * @Gedmo\Versioned()
     */
    private $facebook;

    /**
     * Instagram account.
     *
     * @var string
     *
     * @Assert\Length(max=64)
     *
     * @ORM\Column(type="string", length=64, name="sn_instagram", nullable=true, options={"comment":"Instagram account"})
     *
     * @Gedmo\Versioned()
     */
    private $instagram;

    /**
     * LinkedIn account.
     *
     * @var string
     *
     * @Assert\Length(max=64)
     *
     * @ORM\Column(type="string", length=64, name="sn_linked_in", nullable=true, options={"comment":"LinkedIn account"})
     *
     * @Gedmo\Versioned()
     */
    private $linkedIn;

    /**
     * Twitter account.
     *
     * @var string
     *
     * @Assert\Length(max=64)
     *
     * @ORM\Column(type="string", length=64, name="sn_twitter", nullable=true, options={"comment":"Twitter account"})
     *
     * @Gedmo\Versioned()
     */
    private $twitter;

    /**
     * Youtube account.
     *
     * @var string
     *
     * @Assert\Length(max=64)
     *
     * @ORM\Column(type="string", length=64, name="sn_youtube", nullable=true, options={"comment":"Youtube account"})
     *
     * @Gedmo\Versioned()
     */
    private $youtube;

    /**
     * Facebook getter.
     *
     * @return string|null
     */
    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    /**
     * Facebook fluent setter.
     *
     * @param string|null $facebook
     *
     * @return SocialInterface|SocialTrait
     */
    public function setFacebook(?string $facebook): SocialInterface
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Instagram getter.
     *
     * @return string|null
     */
    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    /**
     * Instagram fluent setter.
     *
     * @param string|null $instagram
     *
     * @return SocialInterface|SocialTrait
     */
    public function setInstagram(?string $instagram): SocialInterface
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * LinkedIn getter.
     *
     * @return string|null
     */
    public function getLinkedIn(): ?string
    {
        return $this->linkedIn;
    }

    /**
     * LinkedIn fluent setter.
     *
     * @param string|null $linkedIn
     *
     * @return SocialInterface|SocialTrait
     */
    public function setLinkedIn(?string $linkedIn): SocialInterface
    {
        $this->linkedIn = $linkedIn;

        return $this;
    }

    /**
     * Twitter getter.
     *
     * @return string|null
     */
    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    /**
     * Twitter fluent setter.
     *
     * @param string|null $twitter
     *
     * @return SocialInterface|SocialTrait
     */
    public function setTwitter(?string $twitter): SocialInterface
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Youtube getter.
     *
     * @return string|null
     */
    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    /**
     * Youtube fluent setter.
     *
     * @param string|null $youtube
     *
     * @return SocialInterface|SocialTrait
     */
    public function setYoutube(?string $youtube): SocialInterface
    {
        $this->youtube = $youtube;

        return $this;
    }
}
