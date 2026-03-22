<?php

namespace functional\controllers;

use FunctionalTester;

class AlbumControllerCest
{
    public function _before(FunctionalTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
    }

    public function testViewReturnsAlbumWithPhotos(FunctionalTester $I)
    {
        $I->wantTo('проверить получение альбома с вложенными фото');

        $I->sendGet('/albums/1');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'id' => 1,
        ]);

        $I->seeResponseJsonMatchesJsonPath('$.photos');
    }

    public function testViewNotFoundException(FunctionalTester $I)
    {
        $I->wantTo('get 404');

        $I->sendGet('/albums/999');

        $I->seeResponseCodeIs(404);
        $I->seeResponseContainsJson([
            'name' => 'Not Found',
            'message' => 'Album not found'
        ]);
    }

    public function testInvalidIdFormat(FunctionalTester $I)
    {
        $I->wantTo('send string instead int');

        $I->sendGet('/albums/wrong-format');

        $I->seeResponseCodeIs(404);
    }
}