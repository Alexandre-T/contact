<?php
/**
 * This file is part of the organization Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Functional test
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests;

/**
 * Organization Cest.
 *
 * Test all actions available for organiser.
 */
class OrganizationCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->wantTo('be connected as organiser.');
        $I->amOnPage('/login');
        $I->seeResponseCodeIsSuccessful();
        $I->fillField('Adresse email', 'organiser@example.org');
        $I->fillField('Mot de passe', 'organiser');
        $I->click(' Se connecter'); //Be careful Se connecter began with ALT+0160 character
        $I->seeCurrentUrlEquals('/');
    }

    /**
     * Test the organization CRUD.
     *
     * @param AcceptanceTester $I
     */
    public function tryToTest(AcceptanceTester $I)
    {
        $I->click('Organisations');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals('/organization');
        $I->see('Organization-0');
        $I->see('Legal name 0');
        $I->seeLink('Éditer');
        $I->seeLink('2');
        $I->seeLink('Suivant »');

        $I->click('Créer');
        $I->fillField('Nom', 'ACodeception');
        $I->fillField('Nom juridique', 'AJuridique');
        $I->fillField('Nom complet', 'ANom');
        $I->fillField('Complément', 'Box 42');
        $I->fillField('Code postal', '42180');
        $I->selectText('Pays', 'France');
        $I->click('Enregistrer');
        $I->seeResponseCodeIsSuccessful();
        $id = $I->grabFromCurrentUrl('~(\d+)~');
        $I->seeCurrentUrlEquals("/organization/$id");
        $I->see('Cette nouvelle organisation a été correctement enregistrée');
        $I->seeLink('Lister');
        $I->seeLink('Éditer');
        $I->see('Nouveau libellé');
        $I->see('Nouveau nom juridique');
        $I->see('Nouveau code postal');
        $I->see('Nouveau complément');
        $I->see('Nouveau pays');
        $I->dontSee('Nouvelle rue');
        $I->click('Éditer');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals("/organization/$id/edit");
        $I->fillField('Adresse', 'Adresse 42');
        $I->fillField('Complément', 'Box Codeception 42');
        $I->click('Enregistrer');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Les modifications sur cette organisation ont été correctement enregistrées');
        $I->seeCurrentUrlEquals("/organization/$id");
        $I->see('Box Codeception 42');
        $I->see('Nouvelle rue');
        $I->see('Nouveau complément');
        $I->see('Box 42');
        $I->see('organiser@example.org');
        $I->submitForm('#delete_form_delete', []);
        $I->see('Cette organisation n’est plus référencée dans l’application');
        $I->seeCurrentUrlEquals('/organization');
        $I->dontSee('ACodeception');
    }
}
