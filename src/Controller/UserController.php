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

use App\Form\Type\UserType;
use App\Entity\User;
use App\Manager\UserManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * UserController class.
 *
 * @category Controller
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license CeCILL-B V1
 *
 * @Route("administration/user")
 * @Security("is_granted('ROLE_MANAGE_USER')")
 */
class UserController extends AbstractController
{
    /**
     * Limit of user per page for listing.
     */
    const LIMIT_PER_PAGE = 25;

    /**
     * Lists all user entities.
     *
     * @Route("/", name="administration_user_index", methods={"get"})
     *
     * @param UserManager $userManager
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(UserManager $userManager, Request $request)
    {
        //Query parameters check
        $field = 'mail' == $request->query->getAlpha('sort') ? 'mail' : 'username';
        $sort = 'desc' == $request->query->getAlpha('direction') ? 'desc' : 'asc';

        $pagination = $userManager->paginate(
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE,
            $field,
            $sort
        );

        return $this->render('administration/user/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="administration_user_new", methods={"get","post"})
     *
     * @param Request $request
     *
     * @return RedirectResponse |Response
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userService = $this->get(UserManager::class);
            $userService->save($user, $this->getUser());
            //Flash message
            $session = $this->get('session');
            $trans = $this->get('translator.default');
            $message = $trans->trans('administration.user.created %name%', ['%name%' => $user->getLabel()]);
            $session->getFlashBag()->add('success', $message);

            return $this->redirectToRoute('administration_user_show', array('id' => $user->getId()));
        }

        return $this->render('@App/administration/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="administration_user_show", methods={"get"})
     *
     * @param User $user
     *
     * @return Response
     */
    public function showAction(User $user)
    {
        /** @var USerManager $userManager */
        $userManager = $this->get(UserManager::class);
        $deleteForm = $this->createDeleteForm($user);
        $information = InformationFactory::createInformation($user);
        $logs = $userManager->retrieveLogs($user);

        return $this->render('@App/administration/user/show.html.twig', [
            'isDeletable' => $userManager->isDeletable($user),
            'logs' => $logs,
            'information' => $information,
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="administration_user_edit", methods={"get", "post"})
     *
     * @param Request $request The request
     * @param User    $user    The user entity
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, User $user)
    {
        $userService = $this->get(UserManager::class);
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm(UserType::class, $user);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $userService->save($user, $this->getUser());
            //$user=$editForm->getData();
            //$em = $this->getDoctrine()->getManager();
            //$em->persist($user);
            //$em->flush();
            //Flash message
            $session = $this->get('session');
            $trans = $this->get('translator.default');
            $message = $trans->trans('administration.user.updated %name%', ['%name%' => $user->getLabel()]);
            $session->getFlashBag()->add('success', $message);

            return $this->redirectToRoute('administration_user_show', array('id' => $user->getId()));
        }
        $logs = $userService->retrieveLogs($user);
        $information = InformationFactory::createInformation($user);

        return $this->render('@App/administration/user/edit.html.twig', [
            'isDeletable' => $userService->isDeletable($user),
            'logs' => $logs,
            'information' => $information,
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="administration_user_delete", methods={"delete"})
     *
     * @param Request $request The request
     * @param User    $user    The $user entity
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);
        $session = $this->get('session');
        $trans = $this->get('translator.default');
        $userManager = $this->get(UserManager::class);
        $isDeletable = $userManager->isDeletable($user);

        if ($isDeletable && $form->isSubmitted() && $form->isValid()) {
            $userManager->delete($user);
            $message = $trans->trans('administration.user.deleted %name%', ['%name%' => $user->getLabel()]);
            $session->getFlashBag()->add('success', $message);
        }elseif (!$isDeletable){

            $message = $trans->trans('administration.user.not-deletable %name%', ['%name%' => $user->getLabel()]);
            $session->getFlashBag()->add('warning', $message);
            return $this->redirectToRoute('administration_user_show', ['id' => $user->getId()]);
        }

        return $this->redirectToRoute('administration_user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return FormInterface The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administration_user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->add('delete', SubmitType::class, [
                'attr' => ['class' => 'btn-danger confirm-delete'],
                'icon' => 'trash-o',
                'label' => 'administration.delete.confirm.delete',
            ])
            ->getForm()
            ;
    }
}
