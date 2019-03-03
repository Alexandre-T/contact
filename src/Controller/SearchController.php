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

use App\Manager\PersonManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Search controller class.
 *
 * Realises all search.
 */
class SearchController extends AbstractController
{
    /**
     * Limit per page.
     */
    const LIMIT_PER_PAGE = 15;

    /**
     * @Route("/search", name="search")
     *
     * @param Request       $request
     * @param PersonManager $personManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, PersonManager $personManager)
    {
        $search = $request->query->getAlpha('search', 'xxxxxxxxxx');
        $personPage = $request->query->getInt('page', 1);

        $personPaginator = $personManager->search($search, $personPage, self::LIMIT_PER_PAGE);

        return $this->render('search/index.html.twig', [
            'personPaginator' => $personPaginator,
            'criteria' => $search,
        ]);
    }
}
