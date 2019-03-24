<?php
/**
 * This file is part of the contact Application.
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
 * Contact Cest.
 *
 * Test all actions available for organiser.
 */
class ContactCest
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
     * Test the contact CRUD.
     *
     * @param AcceptanceTester $I
     */
    public function tryToTest(AcceptanceTester $I)
    {
        $I->click('Contacts');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals('/person');
        $I->see('Jane Doe (Birth)');
        $I->seeLink('Organization-30');
        $I->seeLink('Consulter');
        $I->seeLink('Éditer');
        $I->seeLink('2');
        $I->seeLink('Suivant »');

        $I->click('Créer');
        $I->fillField('Nom de famille', 'ACodeception');
        $I->fillField('Nom de naissance', 'ANaissance');
        $I->fillField('Prénom', 'APrénom');
        $I->fillField('Complément', 'Box 42');
        $I->selectText('Rubrique', 'Universitaire');
        $I->selectText('Membre de', 'Organization-0');
        $I->selectText('Nationalité', 'France');
        $I->selectText('Pays', 'France');
        $I->fillField('Code postal', '42180');
        $I->click('Enregistrer');
        $I->seeResponseCodeIsSuccessful();
        $id = $I->grabFromCurrentUrl('~(\d+)~');
        $I->seeCurrentUrlEquals("/person/$id");
        $I->see('a été créé avec succès');
        $I->seeLink('Lister');
        $I->seeLink('Éditer');
        $I->see('Nouvelle rubrique');
        $I->see('Nouveau prénom');
        $I->dontSee('Nouveau site web');
        $I->see('Nouveau complément');
        $I->click('Éditer');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals("/person/$id/edit");
        $I->fillField('app_person[url]', 'https://codeception.com');
        $I->fillField('Complément', 'Box Codeception 42');
        $I->click('Enregistrer');
        $I->seeResponseCodeIsSuccessful();
        $I->see('a été modifié avec succès');
        $I->seeCurrentUrlEquals("/person/$id");
        $I->seeLink('https://codeception.com');
        $I->see('Box Codeception 42');
        $I->see('Nouveau site web');
        $I->see('Nouveau complément');
        $I->see('Box 42');
        $I->see('organiser@example.org');
        $I->submitForm('#delete_form_delete', []);
        $I->see('a été supprimé avec succès');
        $I->seeCurrentUrlEquals('/person');
    }
}
