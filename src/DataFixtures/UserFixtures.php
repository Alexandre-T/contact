<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Fixtures
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * UserFixtures class.
 *
 * Load user.
 */
class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roleAdmin = ['ROLE_ADMIN'];

        if (in_array(getenv('APP_ENV'), ['dev', 'test'])) {
            //Load dev and test data
            // I add one user for each role (to test the security component)

            //Retrieve roles
            $roleReader = ['ROLE_READER'];
            $roleOrganiser = ['ROLE_ORGANISER'];
            $roleUser = ['ROLE_USER'];

            //Admin
            $userAdministrator = new User();
            $userAdministrator
                ->setLabel('Administrator')
                ->setMail('administrator@example.org')
                ->setPlainPassword('administrator')
                ->setRoles($roleAdmin)
                ->setCreator($userAdministrator);

            //Reader
            $userReader = new User();
            $userReader
                ->setLabel('Reader')
                ->setMail('reader@example.org')
                ->setPlainPassword('reader')
                ->setRoles($roleReader)
                ->setCreator($userAdministrator);

            //ORGANISER
            $userOrganiser = new User();
            $userOrganiser->setLabel('Organiser')
                ->setMail('organiser@example.org')
                ->setPlainPassword('organiser')
                ->setRoles($roleOrganiser)
                ->setCreator($userAdministrator);

            //User
            $userUser = new User();
            $userUser->setLabel('User')
                ->setMail('user@example.org')
                ->setPlainPassword('user')
                ->setRoles($roleUser)
                ->setCreator($userAdministrator);

            //We add 30 users.
            $user = [];
            foreach (range(0, 30) as $index) {
                $user[$index] = new User();
                $user[$index]->setLabel("User $index")
                    ->setMail("user.$index@example.org")
                    ->setPlainPassword('$index')
                    ->setRoles($roleUser)
                    ->setCreator($userAdministrator);
                $manager->persist($user[$index]);
            }

            //These references are perhaps unused.
            $this->addReference('user_reader', $userReader);
            $this->addReference('user_user', $userUser);
            $this->addReference('user_organiser', $userOrganiser);
            $this->addReference('user_admin', $userAdministrator);

            //Persist dev and test data
            $manager->persist($userReader);
            $manager->persist($userUser);
            $manager->persist($userOrganiser);
            $manager->persist($userAdministrator);
        }

        $manager->flush();
    }
}
