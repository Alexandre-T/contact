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

use App\Form\ExportForm;
use App\Form\SearchForm;
use App\Manager\PersonManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Search controller class.
 *
 * Realises all search.
 *
 * @Security("is_granted('ROLE_READER')")
 */
class SearchController extends AbstractController
{
    /**
     * Limit per page.
     */
    const LIMIT_PER_PAGE = 15;

    /**
     * Export limit.
     */
    const EXPORT_LIMIT = 99999;

    /**
     * Search page.
     *
     * @Route("/search/index", name="search")
     *
     * @param Request       $request
     * @param PersonManager $personManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, PersonManager $personManager)
    {
        $personPage = $request->query->getInt('page', 1);

        $form = $this->createForm(SearchForm::class);
        $exportForm = $this->createForm(ExportForm::class);
        $form->handleRequest($request);
        $exportForm->setData($form->getData());

        $personPaginator = $personManager->search($form->getData(), $personPage, self::LIMIT_PER_PAGE);

        return $this->render('search/index.html.twig', [
            'form_search' => $form->createView(),
            'form_export' => $exportForm->createView(),
            'personPaginator' => $personPaginator,
        ]);
    }

    /**
     * Export mail from search results.
     *
     * @Route("/search/mail", name="search_mail")
     *
     * @param Request       $request
     * @param PersonManager $personManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mail(Request $request, PersonManager $personManager)
    {
        $form = $this->createForm(ExportForm::class);
        $form->handleRequest($request);

        $personPaginator = $personManager->search($form->getData(), 1, self::EXPORT_LIMIT);

        $response = $this->render('search/export.csv.twig', [
            'personPaginator' => $personPaginator,
        ]);

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="teams.csv"');

        return $response;
    }
}
