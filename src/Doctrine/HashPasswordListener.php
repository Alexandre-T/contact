<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Doctrine
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Doctrine;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Hash Password Listener.
 *
 * @category Doctrine
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license CeCILL-B V1
 */
class HashPasswordListener implements EventSubscriber
{
    /**
     * The password encoder.
     *
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * HashPasswordListener constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * This subscriber will listen prePersist and preUpdate event.
     *
     * @return array of events this subscriber wants to listen to
     */
    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

    /**
     * This function is called before persist.
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            //This is not a User, so we quit.
            return;
        }

        $this->encodePassword($entity);
    }

    /**
     * This function is called before update.
     *
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        }
        $this->encodePassword($entity);

        // I understand why we do that: it is necessary to force the update to see the change
        $em = $args->getEntityManager();
        // But I do not understand how we can find this solution to force this update.
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

    /**
     * Encode the plain password and pass it to the user entity.
     *
     * @param User $entity
     */
    private function encodePassword(User $entity)
    {
        // Is the user password modified?
        if (!$entity->getPlainPassword()) {
            //No, so we quit
            return;
        }

        // Password encoding
        $encoded = $this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPlainPassword()
        );

        // We pass the encoded password to the Entity
        $entity->setPassword($encoded);
    }
}
