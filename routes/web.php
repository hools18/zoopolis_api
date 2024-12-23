<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/message', function (Request $request) {
        return response()->json(['message' => 'Authorized']);
    });
});
$router->group(['middleware' => 'cors'], function () use ($router) {

    $router->post('/city/requestSave', 'CityController@cityRequestSave');

    $router->post('/city/getList', 'CityController@getList');

    $router->get('/testpay', 'BepaidController@testpay');

	$router->post('/bepaidinfo', 'BepaidController@bepaidinfo');

	$router->get('/user/token', 'UserController@tokenCheck');
	$router->post('/user/token', 'UserController@tokenCheck');
	$router->post('/user/login', 'UserController@login');

	$router->post('/user/logout', 'UserController@logout');

	$router->post('/user/editpass', 'UserController@editpass');


	$router->post('/user/create', 'UserController@newUser');
	$router->post('/user/info', 'UserController@editUser'); // Сохранить изменения в профайле
	$router->post('/user/profile', 'UserController@getProfile'); // Сохранить изменения в профайле
	$router->post('/user/recovery', 'UserController@recoveryProfile'); // Сохранить номер телефона в профайле

	$router->post('/user/phone', 'UserController@editPhoneProfile'); // Сохранить номер телефона в профайле

	$router->post('/user/copytext', 'UserController@copytext'); // Сохранить номер телефона в профайле


	$router->post('/services/missinganimal', 'ServicesController@formMissingAnimal'); // Сохранить номер телефона в профайле
	$router->post('/services/mymissinganimal', 'ServicesController@myMissingAnimal'); // Сохранить номер телефона в профайле

	$router->post('/services/missinganimalall', 'ServicesController@missinganimalall'); // Сохранить номер телефона в профайле
	$router->post('/services/missinganimalgetinfo/{id}', 'ServicesController@getinfo'); // Сохранить номер телефона в профайле
	$router->post('/services/missinganimalupd/{id}', 'ServicesController@missinganimalupd'); // Сохранить номер телефона в профайле



	$router->post('/vetclinics', 'VetclinicsController@all'); // Список вет клиник для карты
	$router->post('/vetclinic/{id}', 'VetclinicsController@get'); // Список вет клиник для карты
	$router->post('/vetclinicupd/{id}', 'VetclinicsController@update'); // Список вет клиник для карты
	$router->post('/newvetclinic', 'VetclinicsController@newclinic'); // Новая клиниа на карте


	$router->post('/subscribe/bay', 'SubscribeController@bay'); // Сохранить номер телефона в профайле
	$router->post('/subscribe/price', 'SubscribeController@getPrice'); // Узнать стоимость услуги
	$router->post('/subscribe/status', 'SubscribeController@status'); // Узнать стоимость услуги

	$router->post('/configs/zooid', 'SubscribeController@configZooid'); // Узнать стоимость услуги
	$router->post('/configs/concierge', 'SubscribeController@configConcierge'); // Узнать стоимость услуги


	$router->post('/promo', 'PromoController@show'); // Сохранить номер телефона в профайле


	$router->post('/configs', 'SearchController@configs');
	$router->post('/search', 'SearchController@search');

	$router->post('/mytexts', 'SearchController@mytexts');

	$router->post('/loadtags', 'SearchController@loadtags');


	$router->post('/user/savedata', 'UserController@saveProfileData');
	$router->post('/user/savedataaddress', 'UserController@saveProfileDataAddress'); // Адрес в профайле
	$router->post('/user/savedatapets', 'UserController@saveProfileDataPets'); // Информация о питомце в профайле

	$router->post('/admin/questions', 'QuestionController@getAllQuestion');
	$router->post('/admin/questions/new', 'QuestionController@newQuestion');

	$router->post('/admin/question', 'QuestionController@getQuestion');	// Получаем информацию о вопросе.
	$router->post('/admin/question/edit', 'QuestionController@editQuestion'); // Сохраняем информацию о вопросе
	$router->post('/admin/question/var', 'QuestionController@addVarQuestion'); // Добавляем вариант ответа

	$router->post('/user/testing', 'QuestionController@getTesting');
	$router->post('/user/questionSend', 'QuestionController@getTestingAnswer');

	$router->post('/contests', 'ContestController@getContestsList'); // Список конкурсов
	$router->post('/contest', 'ContestController@getContestData'); // Загрузка информации и конкурсе (страница конкурса)

	$router->post('/contest/new', 'ContestController@fastCreateContest'); // Быстрая регистрация конкурса по его названию
	$router->post('/contest/namagement', 'ContestController@managementContest'); // Быстрая регистрация конкурса по его названию
	$router->post('/contest/editdata', 'ContestController@getEditContestData'); // Загрузка информации о конкурсе, для его редактирования
	$router->post('/contest/savedata', 'ContestController@saveContestData'); // Сохранение результатов

	$router->post('/authors', 'AuthorsController@getList');
	$router->post('/author', 'AuthorsController@getAuthor');


	$router->get('/hubspot', 'HubspotController@test');


	// Консоль менеджера
	$router->post('/console/users/list', 'ConsoleController@usersList');

	$router->post('/console/tag/list', 'ConsoleController@tagList');
	$router->post('/console/tag/add', 'ConsoleController@tagAdd');

	$router->post('/console/industry/list', 'ConsoleController@industryList');
	$router->post('/console/industry/add', 'ConsoleController@industryAdd');
	$router->post('/console/industry/info', 'ConsoleController@industryInfo');
	$router->post('/console/industry/save', 'ConsoleController@industrySave');

	$router->get('/console/brands/list', 'ConsoleController@brandList');

	$router->post('/console/brands/list', 'ConsoleController@brandList');
	$router->post('/console/brands/add', 'ConsoleController@brandAdd');
	$router->post('/console/brands/info', 'ConsoleController@brandInfo');
	$router->post('/console/brands/save', 'ConsoleController@brandSave');

	$router->post('/console/goal/list', 'ConsoleController@goalList');
	$router->post('/console/goal/add', 'ConsoleController@goalAdd');
	$router->post('/console/socialmedia/list', 'ConsoleController@socialmediaList');
	$router->post('/console/socialmedia/add', 'ConsoleController@socialmediaAdd');
	$router->post('/console/tonesvoice/list', 'ConsoleController@tonesvoiceList');
	$router->post('/console/tonesvoice/add', 'ConsoleController@tonesvoiceAdd');

	$router->post('/console/type/list', 'ConsoleController@typeList');

	$router->post('/console/list/all', 'ConsoleController@alllist');


	$router->post('/console/author/list', 'ConsoleController@authorList');
	$router->post('/console/author/add', 'ConsoleController@authorAdd');
	$router->post('/console/author/info', 'ConsoleController@authorInfo');
	$router->post('/console/author/save', 'ConsoleController@authorSave');

	$router->post('/console/acticles/list', 'ConsoleController@articlesList');
	$router->post('/console/acticles/add', 'ConsoleController@articlesAdd');
	$router->post('/console/acticles/info', 'ConsoleController@articlesInfo');
	$router->post('/console/acticles/save', 'ConsoleController@articlesInfoSave');

	$router->post('/console/acticles/preview', 'ConsoleController@previewText');
	$router->post('/console/acticles/csv', 'ConsoleController@importCsvArticle');


	$router->post('/console/acticles/delete', 'ConsoleController@articleDelete');

	$router->get('/acticles/list', 'ArticlesController@testList');
	$router->post('/acticles/list', 'ArticlesController@testList');

	$router->post('/acticles/copy', 'ArticlesController@saveCopy');


	$router->get('/test/gen', 'TestController@gen');


    $router->get('/oauth/google', 'OauthController@GoogleToken');
    $router->get('/redirect/google', 'OauthController@GoogleTokenReturn');

    $router->post('/oauth', 'OauthController@oauth');


    $router->get('/testmail', 'MailController@html_email');



	// Панель управления
	$router->post('/console/clients/search', 'ConsoleController@clientsSearch');
	$router->post('/console/client/info/{clientID}', 'ConsoleController@clientInfo');

	$router->post('/console/client/blocked/{clientID}', 'UserController@blockedUser');
	$router->post('/console/client/export', 'UserController@getExportUser');
	$router->post('/console/client/savedata/{clientID}', 'UserController@saveProfileData');
	$router->post('/console/client/savedataaddress/{clientID}', 'UserController@saveProfileDataAddress'); // Адрес в профайле
	$router->post('/console/client/savedatapets/{clientID}', 'UserController@saveProfileDataPets'); // Информация о питомце в профайле

	$router->post('/console/client/createnewclient', 'ConsoleController@createNewUser'); // Создание нового клиента по номеру телефона
	$router->post('/console/promo/{id}', 'PromoController@getinfo'); // Создание нового клиента по номеру телефона
	$router->post('/console/promosave/{id}', 'PromoController@saveinfo'); // Создание нового клиента по номеру телефона
	$router->post('/console/promonew', 'PromoController@promoNew'); // Создание нового Промо

	$router->post('/console/servicelist/{type}', 'ConsoleController@serviceList'); // Создание нового Промо
	$router->post('/console/newservice/{type}', 'ConsoleController@serviceNew'); // Создание нового Промо
	$router->post('/console/serviceupdate/{type}/{id}', 'ConsoleController@serviceUpdate'); // Создание нового Промо
	$router->post('/console/deleteservice/{type}/{id}', 'ConsoleController@serviceDelete'); // Создание нового Промо

	$router->post('/console/hideservice/{type}/{id}', 'ConsoleController@serviceHide'); // Скрыть услугу
	$router->post('/console/showservice/{type}/{id}', 'ConsoleController@serviceShow'); // Отобразить услугу

});


