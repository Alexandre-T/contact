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
use Symfony\Contracts\Translation\TranslatorInterface;

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
            $message = $trans->trans('entity.user.created %name%', ['%name%' => $user->getLabel()]);
            $session->getFlashBag()->add('success', $message);

            return $this->redirectToRoute('administration_user_show', array('id' => $user->getId()));
        }

        return $this->render('administration/user/new.html.twig', [
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
     * @param UserManager $userManager
     *
     * @return Response
     */
    public function showAction(User $user, UserManager $userManager)
    {
        $deleteForm = $this->createDeleteForm($user);
        $logs = $userManager->retrieveLogs($user);

        return $this->render('administration/user/show.html.twig', [
            'isDeletable' => $userManager->isDeletable($user),
            'logs' => $logs,
            'information' => $user,
            'user' => $user,
            'deletable' => $userManager->isDeletable($user),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="administration_user_edit", methods={"get", "post"})
     *
     * @param User $user The user entity
     *
     * @param Request $request The request
     * @param UserManager $userManager
     * @param TranslatorInterface $trans
     * @return RedirectResponse|Response
     */
    public function editAction(User $user, Request $request, UserManager $userManager, TranslatorInterface $trans)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm(UserType::class, $user);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $userManager->save($user, $this->getUser());
            $session = $this->get('session');
            $message = $trans->trans('entity.user.updated %name%', ['%name%' => $user->getLabel()]);
            $session->getFlashBag()->add('success', $message);

            return $this->redirectToRoute('administration_user_show', array('id' => $user->getId()));
        }
        $logs = $userManager->retrieveLogs($user);

        return $this->render('administration/user/edit.html.twig', [
            'deletable' => $userManager->isDeletable($user),
            'logs' => $logs,
            'information' => $user,
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
     * @param User $user The $user entity
     * @param Request $request The request
     * @param UserManager $userManager
     * @param TranslatorInterface $trans
     *
     * @return RedirectResponse
     */
    public function deleteAction(User $user, Request $request, UserManager $userManager, TranslatorInterface $trans)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);
        $isDeletable = $userManager->isDeletable($user);

        if ($isDeletable && $form->isSubmitted() && $form->isValid()) {
            $session = $this->get('session');
            $userManager->delete($user);
            $message = $trans->trans('entity.user.deleted %name%', ['%name%' => $user->getLabel()]);
            $session->getFlashBag()->add('success', $message);
        }elseif (!$isDeletable){
            $session = $this->get('session');
            $message = $trans->trans('entity.user.deleted %name%', ['%name%' => $user->getLabel()]);
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
                //FIXME add icon
                //'icon' => 'trash-o',
                'label' => 'modal.entity.delete.yes',
            ])
            ->getForm()
            ;
    }
}
