<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Tests
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Tests;

/**
 * Security Cest.
 *
 * Test access by roles.
 */
class SecurityCest
{
    /**
     * Before each test.
     *
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
    }

    /**
     * Test administrator access.
     *
     * @param AcceptanceTester $I
     */
    public function tryToTestAdministratorAccess(AcceptanceTester $I)
    {
        $I->wantTo('be connected as administrator.');
        $I->amOnPage('/login');
        $I->seeResponseCodeIsSuccessful();
        $I->fillField('Adresse email', 'administrator@example.org');
        $I->fillField('Mot de passe', 'administrator');
        $I->click(' Se connecter'); //Be careful Se connecter began with ALT+0160 character
        $I->seeCookie('PHPSESSID');
        $I->seeCurrentUrlEquals('/');

        //We are connected as administrator and are on home page
        $I->wantToTest('administrator see links');
        $I->dontSeeLink('Contacts');
        $I->dontSeeLink('Organisations');
        $I->seeLink('Utilisateurs');

        $I->wantToTest('Administrator can access home pages.');
        $I->click(' Accueil');
        $I->seeCurrentUrlEquals('/');
        $I->seeResponseCodeIsSuccessful();

        $I->wantToTest('Administrator can access admin pages.');
        $I->click('Utilisateurs');
        $I->seeCurrentUrlEquals('/administration/user');
        $I->seeResponseCodeIsSuccessful();
        $I->click('Créer');
        $I->seeCurrentUrlEquals('/administration/user/new');
        $I->seeResponseCodeIsSuccessful();

        $I->wantToTest('Administrator cannot access contact pages.');
        $I->amOnPage('/person');
        $I->seeResponseCodeIs(403);
        $I->amOnPage('/person/new');
        $I->seeResponseCodeIs(403);
        $I->amOnPage('/person/service/organization.json');
        $I->seeResponseCodeIs(403);

        $I->wantToTest('Administrator cannot access organization pages.');
        $I->amOnPage('/organization');
        $I->seeResponseCodeIs(403);
        $I->amOnPage('/organization/new');
        $I->seeResponseCodeIs(403);

        $I->wantToTest('Administrator cannot access search page.');
        $I->amOnPage('/search');
        $I->seeResponseCodeIs(403);

        $I->wantToTest('Administrator cannot access register page.');
        $I->amOnPage('/register');
        //$I->seeResponseCodeIsRedirection();
        $I->seeCurrentUrlEquals('/');

        $I->wantToTest('Administrator cannot access login page.');
        $I->amOnPage('/login');
        //$I->seeResponseCodeIsRedirection();
        $I->seeCurrentUrlEquals('/');

        $I->wantToTest('Administrator can access logout page.');
        $I->click('Déconnexion');
        //$I->seeResponseCodeIsRedirection();
        $I->amOnPage('/');
        $I->seeLink('Connexion');
        $I->seeLink('Inscription');
    }

    /**
     * Test anonymous user access.
     *
     * @param AcceptanceTester $I
     */
    public function tryToTestAnonymousAccess(AcceptanceTester $I)
    {
        $I->wantToTest('Anonymous user can access home page.');
        $I->amOnPage('/');
        $I->seeResponseCodeIsSuccessful();
        $I->wantToTest('Anonymous user can access register page.');
        $I->amOnPage('/register');
        $I->seeResponseCodeIsSuccessful();
        $I->wantToTest('Anonymous user can access logout page and is redirected on home page.');
        $I->amOnPage('/logout');
        $I->seeCurrentUrlEquals('/');
        $I->seeResponseCodeIsSuccessful();

        $I->wantToTest('Anonymous user do not see some links.');
        $I->dontSeeLink('Contacts');
        $I->dontSeeLink('Organisations');
        $I->dontSeeLink('Utilisateurs');

        $I->wantToTest('Anonymous user cannot access contact pages.');
        $I->amOnPage('/person');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals('/login');
        $I->amOnPage('/person/new');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals('/login');
        $I->amOnPage('/person/service/organization.json');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals('/login');

        $I->wantToTest('Anonymous user cannot access organization pages.');
        $I->amOnPage('/organization');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals('/login');
        $I->amOnPage('/organization/new');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals('/login');

        $I->wantToTest('Anonymous user cannot access search pages.');
        $I->amOnPage('/search');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals('/login');

        $I->wantToTest('Anonymous user cannot access admin pages.');
        $I->amOnPage('/administration/user');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals('/login');
        $I->amOnPage('/administration/user/new');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals('/login');
    }
}
