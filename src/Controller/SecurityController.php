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

namespace App\Controller;

use App\Form\LoginForm;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Security Controller.
 *
 * @category Controller
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license CeCILL-B V1
 */
class SecurityController extends AbstractController
{
    /**
     * Login Action.
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     *
     * @Route("/login", name="security_login", methods={"get","post"})
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username (even if it a mail) entered by the user
        $email = $authenticationUtils->getLastUsername();

        // create the form
        $form = $this->createForm(LoginForm::class, ['mail' => $email]);

        return $this->render('security/login.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
        ));
    }

    /**
     * The logout route should not be reached.
     *
     * @Route("/logout", name="security_logout")
     *
     * @throws \Exception
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }
}
