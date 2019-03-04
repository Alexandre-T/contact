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

use App\Entity\Organization;
use App\Form\OrganizationForm;
use App\Manager\OrganizationManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Organization controller class.
 *
 * @Route("/organization")
 * @Security("is_granted('ROLE_READ_ORGANIZATION')")
 */
class OrganizationController extends AbstractController
{
    /**
     * List all organizations action.
     *
     * @Route("/", name="organization_index", methods={"GET"})
     *
     * @param Request             $request
     * @param OrganizationManager $organizationManager
     *
     * @return Response
     */
    public function index(Request $request, OrganizationManager $organizationManager): Response
    {
        //Query parameters check
        //FIXME add a test which throw a 403 error if field is not valid to avoid DQL error.
        $field = 'label' == $request->query->getAlpha('sort') ? 'legal' : 'label';
        $sort = 'desc' == $request->query->getAlpha('direction') ? 'desc' : 'asc';

        $pagination = $organizationManager->paginate(
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE,
            $field,
            $sort
        );

        return $this->render('organization/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * Creates a new organization entity.
     *
     * @Route("/new", name="organization_new", methods={"get","post"})
     *
     * @param OrganizationManager $organizationManager
     * @param Request             $request
     * @param TranslatorInterface $trans
     *
     * @return RedirectResponse |Response
     */
    public function newAction(OrganizationManager $organizationManager, Request $request, TranslatorInterface $trans)
    {
        $organization = $organizationManager->createOrganization();
        $form = $this->createForm(OrganizationForm::class, $organization);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $organizationManager->save($organization, $this->getUser());
            //Flash message
            $session = $this->get('session');
            $message = $trans->trans('entity.organization.created %name%', ['%name%' => $organization->getLabel()]);
            $session->getFlashBag()->add('success', $message);

            return $this->redirectToRoute('organization_show', array('id' => $organization->getId()));
        }

        return $this->render('organization/new.html.twig', [
            'organization' => $organization,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Limit of organizations per page for listing.
     */
    const LIMIT_PER_PAGE = 25;

    /**
     * Find and display a organization entity.
     *
     * @Route("/{id}", name="organization_show", methods={"get"})
     *
     * @param Organization        $organization
     * @param OrganizationManager $organizationManager
     * @param Request             $request
     *
     * @return Response
     */
    public function showAction(Organization $organization, OrganizationManager $organizationManager, Request $request)
    {
        $page = $request->query->getInt('page', 1);
        $deleteForm = $this->createDeleteForm($organization);
        $logs = $organizationManager->retrieveLogs($organization);
        $addressLogs = $organizationManager->retrieveLogs($organization->getAddress());
        $contactPagination = $organizationManager->getContacts($organization, $page, self::LIMIT_PER_PAGE);

        return $this->render('organization/show.html.twig', [
            'isDeletable' => $organizationManager->isDeletable($organization),
            'logs' => $logs,
            'addressLogs' => $addressLogs,
            'information' => $organization,
            'organization' => $organization,
            'pagination' => $contactPagination,
            'deletable' => $organizationManager->isDeletable($organization),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing organization entity.
     *
     * @Route("/{id}/edit", name="organization_edit", methods={"get", "post"})
     *
     * @param Organization        $organization        The organization entity
     * @param Request             $request             The request
     * @param OrganizationManager $organizationManager
     * @param TranslatorInterface $trans
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Organization $organization, Request $request, OrganizationManager $organizationManager, TranslatorInterface $trans)
    {
        $deleteForm = $this->createDeleteForm($organization);
        $editForm = $this->createForm(OrganizationForm::class, $organization);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $organizationManager->save($organization, $this->getUser());
            $session = $this->get('session');
            $message = $trans->trans('entity.organization.updated %name%', ['%name%' => $organization->getLabel()]);
            $session->getFlashBag()->add('success', $message);

            return $this->redirectToRoute('organization_show', array('id' => $organization->getId()));
        }
        $logs = $organizationManager->retrieveLogs($organization);

        return $this->render('organization/edit.html.twig', [
            'deletable' => $organizationManager->isDeletable($organization),
            'logs' => $logs,
            'information' => $organization,
            'organization' => $organization,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a organization entity.
     *
     * @Route("/{id}", name="organization_delete", methods={"delete"})
     *
     * @param Organization        $organization        The $organization entity
     * @param Request             $request             The request
     * @param OrganizationManager $organizationManager
     * @param TranslatorInterface $trans
     *
     * @return RedirectResponse
     */
    public function deleteAction(Organization $organization, Request $request, OrganizationManager $organizationManager, TranslatorInterface $trans): RedirectResponse
    {
        $form = $this->createDeleteForm($organization);
        $form->handleRequest($request);
        $isDeletable = $organizationManager->isDeletable($organization);

        if ($isDeletable && $form->isSubmitted() && $form->isValid()) {
            $session = $this->get('session');
            $organizationManager->delete($organization);
            $message = $trans->trans('entity.organization.deleted %name%', ['%name%' => $organization->getLabel()]);
            $session->getFlashBag()->add('success', $message);
        } elseif (!$isDeletable) {
            $session = $this->get('session');
            $message = $trans->trans('entity.organization.deleted %name%', ['%name%' => $organization->getLabel()]);
            $session->getFlashBag()->add('warning', $message);

            return $this->redirectToRoute('organization_show', ['id' => $organization->getId()]);
        }

        return $this->redirectToRoute('organization_index');
    }

    /**
     * Creates a form to delete a organization entity.
     *
     * @param Organization $organization The organization entity
     *
     * @return FormInterface The form
     */
    private function createDeleteForm(Organization $organization): FormInterface
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('organization_delete', array('id' => $organization->getId())))
            ->setMethod('DELETE')
            ->add('delete', SubmitType::class, [
                'attr' => ['class' => 'btn-danger confirm-delete'],
                //TODO add icon
                //'icon' => 'trash-o',
                'label' => 'modal.entity.delete.yes',
            ])
            ->getForm()
            ;
    }
}
