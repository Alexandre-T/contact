<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\Service;
use App\Form\ServiceForm;
use App\Manager\ServiceManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Service controller class.
 *
 * @Route("/service")
 * @Security("is_granted('ROLE_MANAGE_ORGANIZATION')")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/new/{organization}", name="service")
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
}
