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

/**
 * Social network interface.
 */
interface SocialInterface
{
    /**
     * Facebook getter.
     *
     * @return string|null
     */
    public function getFacebook(): ?string;

    /**
     * Facebook fluent setter.
     *
     * @param string|null $facebook
     *
     * @return SocialInterface
     */
    public function setFacebook(?string $facebook): self;

    /**
     * Instagram getter.
     *
     * @return string|null
     */
    public function getInstagram(): ?string;

    /**
     * Instagram fluent setter.
     *
     * @param string|null $instagram
     *
     * @return SocialInterface
     */
    public function setInstagram(?string $instagram): self;

    /**
     * LinkedIn getter.
     *
     * @return string|null
     */
    public function getLinkedIn(): ?string;

    /**
     * LinkedIn fluent setter.
     *
     * @param string|null $linkedIn
     *
     * @return SocialInterface
     */
    public function setLinkedIn(?string $linkedIn): self;

    /**
     * Twitter getter.
     *
     * @return string|null
     */
    public function getTwitter(): ?string;

    /**
     * Twitter fluent setter.
     *
     * @param string|null $twitter
     *
     * @return SocialInterface
     */
    public function setTwitter(?string $twitter): self;

    /**
     * Youtube getter.
     *
     * @return string|null
     */
    public function getYoutube(): ?string;

    /**
     * Youtube fluent setter.
     *
     * @param string|null $youtube
     *
     * @return SocialInterface
     */
    public function setYoutube(?string $youtube): self;
}
