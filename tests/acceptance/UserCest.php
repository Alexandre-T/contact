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
class UserCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->wantTo('be connected as administrator.');
        $I->amOnPage('/login');
        $I->seeResponseCodeIsSuccessful();
        $I->fillField('Adresse email', 'administrator@example.org');
        $I->fillField('Mot de passe', 'administrator');
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
        $I->click('Utilisateurs');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals('/administration/user');
        $I->see('Administrator');
        $I->see('administrator@example.org');
        $I->seeLink('Consulter');
        $I->seeLink('Éditer');
        $I->seeLink('2');
        $I->seeLink('Suivant »');

        $I->click('Créer');
        $I->fillField('Nom de l’utilisateur', 'ACodeception');
        $I->fillField('Adresse email', 'codeception@example.org');
        $I->checkOption('#app_user_roles_1');
        $I->checkOption('#app_user_roles_2');
        $I->click('Créer');
        $I->seeResponseCodeIsSuccessful();
        $id = $I->grabFromCurrentUrl('~(\d+)~');
        $I->seeCurrentUrlEquals("/administration/user/$id");
        $I->see('a été créé avec succès');
        $I->seeLink('Lister');
        $I->seeLink('Éditer');
        $I->dontSee('Administrateur pouvant gérer les privilèges des utilisateurs.');
        $I->see('Utilisateur avec droit de lecture et d’écriture.');
        $I->see('Utilisateur avec droit de lecture uniquement.');
        $I->see('Nouveau mot de passe');
        $I->see('Nouvel email');
        $I->click('Éditer');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentUrlEquals("/administration/user/$id/edit");
        $I->fillField('Nom de l’utilisateur', 'AACodeception');
        $I->checkOption('#app_user_roles_0');
        $I->click('Éditer', '.btn-primary');
        $I->seeResponseCodeIsSuccessful();
        $I->see('a été modifié avec succès');
        $I->seeCurrentUrlEquals("/administration/user/$id");
        $I->see('administrator@example.org');
        $I->see('Administrateur pouvant gérer les privilèges des utilisateurs.');
        $I->submitForm('#delete_form_delete', []);
        $I->see('a été supprimé avec succès');
        $I->seeCurrentUrlEquals('/administration/user');
    }
}
