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
use Symfony\Component\Security\Core\User\UserInterface;
use Serializable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Entity User.
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(
 *     name="ts_user",
 *     schema="data",
 *     options={"comment":"Table entité des utilisateur","charset":"utf8mb4","collate":"utf8mb4_unicode_ci"},
 *     indexes={
 *          @ORM\Index(name="ndx_user_creator", columns={"creator_id"}),
 *     },
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="uk_user_mail", columns={"usr_mail"}),
 *          @ORM\UniqueConstraint(name="uk_user_label", columns={"usr_label"})
 *     }
 * )
 *
 * @Gedmo\Loggable
 *
 * @UniqueEntity("mail", message="error.user.mail.unique")
 * @UniqueEntity("label", message="error.user.label.unique")
 */
class User implements EntityInterface, InformationInterface, LabelInterface, UserInterface, Serializable
{
    use EntityTrait;

    /**
     * Identifier.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", name="usr_id", options={"unsigned":true,"comment":"Identifiant de l'utilisateur"})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * User label.
     * This is NOT the identifier nether the 'technical' username.
     *
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Length(max="32")
     *
     * @ORM\Column(type="string", unique=true, length=32, name="usr_label", options={"unsigned":true})
     * @Gedmo\Versioned
     */
    private $label;

    /**
     * User mail and identifier.
     *
     * @var string
     * @Assert\Length(max="255")
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Email()
     *
     * @ORM\Column(type="string", unique=true, length=255, name="usr_mail")
     * @Gedmo\Versioned
     */
    private $mail;

    /**
     * User encoded password.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=true, options={"comment":"Mot de passe crypté"})
     * @Gedmo\Versioned
     */
    private $password;

    /**
     * Roles of this user.
     *
     * @var array
     *
     * @Assert\Count(
     *     min = 1,
     *     minMessage="form.error.roles.empty"
     * )
     *
     * @ORM\Column(type="json_array", nullable=true, options={"comment":"Roles de l'utilisateur"})
     *
     * @Gedmo\Versioned
     */
    private $roles = [];

    /**
     * A non-persisted field that's used to create the encoded password.
     *
     * @var string
     */
    private $plainPassword;

    /**
     * Id getter.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Label/Username getter.
     *
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Mail getter.
     *
     * @return string
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * The encoded password.
     *
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Return the non-persistent plain password.
     *
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * Return an array of all role codes to be compliant with UserInterface
     * This is NOT the Roles getter.
     *
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * To implements UserInterface.
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Setter of the label of user.
     *
     * @param string $label
     *
     * @return User
     */
    public function setLabel(string $label): User
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Setter of the mail.
     *
     * @param string $mail
     *
     * @return User
     */
    public function setMail(string $mail): User
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Setter of the password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set the non-persistent plain password.
     *
     * @param string $plainPassword
     *
     * @return User
     */
    public function setPlainPassword(string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;
        // forces the object to look "dirty" to Doctrine. Avoids
        // Doctrine *not* saving this entity, if only plainPassword changes
        // @see https://knpuniversity.com/screencast/symfony-security/user-plain-password
        $this->password = null;

        return $this;
    }

    /**
     * Setter of the roles.
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Return the label of user.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return (string) $this->getMail();
    }

    /**
     * Set the username of user.
     *
     * @param string $username the new username
     *
     * @return User
     */
    public function setUsername(string $username): User
    {
        return $this->setMail($username);
    }

    /**
     * Erase Credentials.
     *
     * @return User
     */
    public function eraseCredentials(): User
    {
        $this->plainPassword = null;

        return $this;
    }

    /**
     * String representation of object.
     *
     * @see http://php.net/manual/en/serializable.serialize.php
     * @see \Serializable::serialize()
     *
     * @return string the string representation of the object or null
     */
    public function serialize(): string
    {
        return serialize(array(
            $this->id,
            $this->label,
            $this->mail,
            $this->password,
            $this->created,
            $this->creator,
            $this->roles,
            $this->updated,
        ));
    }

    /**
     * Constructs the object.
     *
     * @see http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized the string representation of the user instance
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->label,
            $this->mail,
            $this->password,
            $this->created,
            $this->creator,
            $this->roles,
            $this->updated) = unserialize($serialized);
    }

    /**
     * Return if actual user has the mentioned role.
     *
     * @param string $role
     *
     * @return bool true if the user has the mentioned role
     */
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->getRoles());
    }

    /**
     * Is this user an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return in_array('ROLE_ADMIN', $this->getRoles());
    }
}
