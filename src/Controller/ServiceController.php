<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\Service;
use App\Form\DeleteForm;
use App\Form\ServiceForm;
use App\Manager\ServiceManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Service controller class.
 *
 * @Route("/service")
 * @Security("is_granted('ROLE_READ_ORGANIZATION')")
 */
class ServiceController extends AbstractController
{
    /**
     * Deletes a service entity.
     *
     * @Route("/{id}", name="service_delete", methods={"delete"})
     *
     * @param Service             $service        The $service entity
     * @param Request             $request        The request
     * @param ServiceManager      $serviceManager
     * @param TranslatorInterface $trans
     *
     * @return RedirectResponse
     *
     * @Security("is_granted('ROLE_MANAGE_ORGANIZATION')")
     */
    public function deleteAction(Service $service, Request $request, ServiceManager $serviceManager, TranslatorInterface $trans): RedirectResponse
    {
        $form = $deleteForm = $this->createForm(DeleteForm::class, $service);
        $form->handleRequest($request);
        $isDeletable = $serviceManager->isDeletable($service);
        $organization = $service->getOrganization();

        if ($isDeletable && $form->isSubmitted() && $form->isValid()) {
            $session = $this->get('session');
            $serviceManager->delete($service);
            $message = $trans->trans('entity.service.deleted %name%', ['%name%' => $service->getLabel()]);
            $session->getFlashBag()->add('success', $message);
        } elseif (!$isDeletable) {
            $session = $this->get('session');
            $message = $trans->trans('entity.service.deleted %name%', ['%name%' => $service->getLabel()]);
            $session->getFlashBag()->add('warning', $message);

            return $this->redirectToRoute('service_show', ['id' => $service->getId()]);
        }

        return $this->redirectToRoute('organization_show', ['id' => $organization->getId()]);
    }

    /**
     * Displays a form to edit an existing service entity.
     *
     * @Route("/{id}/edit", name="service_edit", methods={"get", "post"})
     *
     * @param Service             $service        The service entity
     * @param Request             $request        The request
     * @param ServiceManager      $serviceManager
     * @param TranslatorInterface $trans
     *
     * @return RedirectResponse|Response
     *
     * @Security("is_granted('ROLE_MANAGE_ORGANIZATION')")
     */
    public function editAction(Service $service, Request $request, ServiceManager $serviceManager, TranslatorInterface $trans)
    {
        $deleteForm = $this->createForm(DeleteForm::class, $service);
        $editForm = $this->createForm(ServiceForm::class, $service);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $serviceManager->save($service, $this->getUser());
            $session = $this->get('session');
            $message = $trans->trans('entity.service.updated %name%', ['%name%' => $service->getLabel()]);
            $session->getFlashBag()->add('success', $message);

            return $this->redirectToRoute('service_show', array('id' => $service->getId()));
        }
        $logs = $serviceManager->retrieveLogs($service);

        return $this->render('service/edit.html.twig', [
            'deletable' => $serviceManager->isDeletable($service),
            'logs' => $logs,
            'information' => $service,
            'service' => $service,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("/new/{organization}", name="service_new")
     *
     * @param ServiceManager      $serviceManager
     * @param Request             $request
     * @param TranslatorInterface $trans
     * @param Organization        $organization
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(ServiceManager $serviceManager, Request $request, TranslatorInterface $trans, Organization $organization)
    {
        $service = new Service();
        $service->setOrganization($organization);
        $form = $this->createForm(ServiceForm::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $serviceManager->save($service, $this->getUser());
            //Flash message
            $session = $this->get('session');
            $message = $trans->trans('entity.service.created %name%', ['%name%' => $service->getName()]);
            $session->getFlashBag()->add('success', $message);

            return $this->redirectToRoute('organization_show', array('id' => $organization->getId()));
        }

        return $this->render('service/new.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Find and display a service entity.
     *
     * @Route("/{id}", name="service_show", methods={"get"})
     *
     * @param Service        $service
     * @param ServiceManager $serviceManager
     *
     * @return Response
     */
    public function showAction(Service $service, ServiceManager $serviceManager)
    {
        $deleteForm = $deleteForm = $this->createForm(DeleteForm::class, $service);
        $logs = $serviceManager->retrieveLogs($service);

        return $this->render('service/show.html.twig', [
            'isDeletable' => $serviceManager->isDeletable($service),
            'logs' => $logs,
            'information' => $service,
            'service' => $service,
            'deletable' => $serviceManager->isDeletable($service),
            'delete_form' => $deleteForm->createView(),
        ]);
    }
}
