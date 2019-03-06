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

use App\Entity\Person;
use App\Form\PersonForm;
use App\Manager\PersonManager;
use App\Repository\ServiceRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Person controller class.
 *
 * @Route("/person")
 * @Security("is_granted('ROLE_READ_CONTACT')")
 */
class PersonController extends AbstractController
{
    /**
     * Limit of persons per page for listing.
     */
    const LIMIT_PER_PAGE = 25;

    /**
     * List all persons action.
     *
     * @Route("/", name="person_index", methods={"GET"})
     *
     * @param Request       $request
     * @param PersonManager $personManager
     *
     * @return Response
     */
    public function index(Request $request, PersonManager $personManager): Response
    {
        //Query parameters check
        //FIXME add a test which throw a 403 error if field is not valid to avoid DQL error.
        $field = 'job' == $request->query->getAlpha('sort') ? 'job' : 'family';
        $sort = 'desc' == $request->query->getAlpha('direction') ? 'desc' : 'asc';

        $pagination = $personManager->paginate(
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE,
            $field,
            $sort
        );

        return $this->render('person/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * Creates a new person entity.
     *
     * @Route("/new", name="person_new", methods={"get","post"})
     *
     * @param PersonManager       $personManager
     * @param Request             $request
     * @param TranslatorInterface $trans
     *
     * @return RedirectResponse |Response
     *
     * @Security("is_granted('ROLE_MANAGE_CONTACT')")
     */
    public function newAction(PersonManager $personManager, Request $request, TranslatorInterface $trans)
    {
        $person = $personManager->createPerson();
        $form = $this->createForm(PersonForm::class, $person);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personManager->save($person, $this->getUser());
            //Flash message
            $session = $this->get('session');
            $message = $trans->trans('entity.person.created %name%', ['%name%' => $person->getLabel()]);
            $session->getFlashBag()->add('success', $message);

            return $this->redirectToRoute('person_show', array('id' => $person->getId()));
        }

        return $this->render('person/new.html.twig', [
            'person' => $person,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Find and display a person entity.
     *
     * @Route("/{id}", name="person_show", methods={"get"})
     *
     * @param Person        $person
     * @param PersonManager $personManager
     *
     * @return Response
     */
    public function showAction(Person $person, PersonManager $personManager)
    {
        $deleteForm = $this->createDeleteForm($person);
        $logs = $personManager->retrieveLogs($person);
        $addressLogs = $personManager->retrieveLogs($person->getAddress());

        return $this->render('person/show.html.twig', [
            'isDeletable' => $personManager->isDeletable($person),
            'logs' => $logs,
            'addressLogs' => $addressLogs,
            'information' => $person,
            'person' => $person,
            'deletable' => $personManager->isDeletable($person),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to delete a person entity.
     *
     * @param Person $person The person entity
     *
     * @return FormInterface The form
     */
    private function createDeleteForm(Person $person): FormInterface
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('person_delete', array('id' => $person->getId())))
            ->setMethod('DELETE')
            ->add('delete', SubmitType::class, [
                'attr' => ['class' => 'btn-danger confirm-delete'],
                //TODO add icon
                //'icon' => 'trash-o',
                'label' => 'modal.entity.delete.yes',
            ])
            ->getForm();
    }

    /**
     * Displays a form to edit an existing person entity.
     *
     * @Route("/{id}/edit", name="person_edit", methods={"get", "post"})
     *
     * @param Person              $person        The person entity
     * @param Request             $request       The request
     * @param PersonManager       $personManager
     * @param TranslatorInterface $trans
     *
     * @return RedirectResponse|Response
     *
     * @Security("is_granted('ROLE_MANAGE_CONTACT')")
     */
    public function editAction(Person $person, Request $request, PersonManager $personManager, TranslatorInterface $trans)
    {
        $deleteForm = $this->createDeleteForm($person);
        $editForm = $this->createForm(PersonForm::class, $person);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $personManager->save($person, $this->getUser());
            $session = $this->get('session');
            $message = $trans->trans('entity.person.updated %name%', ['%name%' => $person->getLabel()]);
            $session->getFlashBag()->add('success', $message);

            return $this->redirectToRoute('person_show', array('id' => $person->getId()));
        }
        $logs = $personManager->retrieveLogs($person);

        return $this->render('person/edit.html.twig', [
            'deletable' => $personManager->isDeletable($person),
            'logs' => $logs,
            'information' => $person,
            'person' => $person,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a person entity.
     *
     * @Route("/{id}", name="person_delete", methods={"delete"})
     *
     * @param Person              $person        The $person entity
     * @param Request             $request       The request
     * @param PersonManager       $personManager
     * @param TranslatorInterface $trans
     *
     * @return RedirectResponse
     *
     * @Security("is_granted('ROLE_MANAGE_CONTACT')")
     */
    public function deleteAction(Person $person, Request $request, PersonManager $personManager, TranslatorInterface $trans): RedirectResponse
    {
        $form = $this->createDeleteForm($person);
        $form->handleRequest($request);
        $isDeletable = $personManager->isDeletable($person);

        if ($isDeletable && $form->isSubmitted() && $form->isValid()) {
            $session = $this->get('session');
            $personManager->delete($person);
            $message = $trans->trans('entity.person.deleted %name%', ['%name%' => $person->getLabel()]);
            $session->getFlashBag()->add('success', $message);
        } elseif (!$isDeletable) {
            $session = $this->get('session');
            $message = $trans->trans('entity.person.deleted %name%', ['%name%' => $person->getLabel()]);
            $session->getFlashBag()->add('warning', $message);

            return $this->redirectToRoute('person_show', ['id' => $person->getId()]);
        }

        return $this->redirectToRoute('person_index');
    }

    /**
     * @Route("/service/organization.json", name="service_by_organization", methods={"get"})
     *
     * @param Request $request
     * @param ServiceRepository $serviceRepository
     *
     * @return JsonResponse
     *
     * @Security("is_granted('ROLE_MANAGE_CONTACT')")
     */
    public function listServiceOfOrganization(Request $request, ServiceRepository $serviceRepository): JsonResponse
    {
        $organizationId = $request->query->getInt('organization', 0);
        $services = $serviceRepository->findBy(['organization' => $organizationId]);

        $responseArray = [];
        foreach ($services as $service) {
            $responseArray[] = array(
                'id' => $service->getId(),
                'name' => $service->getName(),
            );
        }

        return new JsonResponse($responseArray);
    }
}
