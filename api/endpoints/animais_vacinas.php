<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '_class/animalVacinaDao.php';

$app->get('/animais_vacinas/{anv_int_codigo}', function (Request $request, Response $response) {
    $anv_int_codigo = $request->getAttribute('anv_int_codigo');
    
    $animal_vacina = new AnimalVacina();
    $animal_vacina->setAnv_int_codigo($anv_int_codigo);

    $data = AnimalVacinaDao::selectByIdForm($animal_vacina);
    $code = count($data) > 0 ? 200 : 404;

	return $response->withJson($data, $code);
});


$app->post('/animais_vacinas', function (Request $request, Response $response) {
    $body = $request->getParsedBody();

    $animal_vacina = new AnimalVacina();

    $animal = new Animal();
    $animal->setAni_int_codigo($body['ani_int_codigo']);

    $vacina = new Vacina();
    $vacina->setVac_int_codigo($body['vac_int_codigo']);

    $animal_vacina->setAnimal($animal);
    $animal_vacina->setVacina($vacina);
    $animal_vacina->setAnv_dat_programacao($body['anv_dat_programacao']);

    $data = AnimalVacinaDao::insert($animal_vacina);
    $code = ($data['status']) ? 201 : 500;

	return $response->withJson($data, $code);
});


$app->put('/animais_vacinas/{anv_int_codigo}', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
	$anv_int_codigo = $request->getAttribute('anv_int_codigo');
    
    $animal_vacina = new AnimalVacina();

    $animal = new Animal();
    $animal->setAni_int_codigo($body['ani_int_codigo']);

    $vacina = new Vacina();
    $vacina->setVac_int_codigo($body['vac_int_codigo']);

    $animal_vacina->setAnv_int_codigo($anv_int_codigo);
    $animal_vacina->setAnimal($animal);
    $animal_vacina->setVacina($vacina);
    $animal_vacina->setAnv_dat_programacao($body['anv_dat_programacao']);

    $data = AnimalVacinaDao::update($animal_vacina);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});

$app->put('/animais_vacinas/{anv_int_codigo}/vacinar', function (Request $request, Response $response) {
    $body = $request->getParsedBody();

	$anv_int_codigo = $request->getAttribute('anv_int_codigo');
    
    $animal_vacina = new AnimalVacina();

    $animal = new Animal();
    $animal->setAni_int_codigo($body['ani_int_codigo']);

    $usuario = new Usuario();
    $usuario->setUsu_int_codigo($body['usu_int_codigo']);

    $animal_vacina->setAnv_int_codigo($anv_int_codigo);
    $animal_vacina->setAnimal($animal);
 	$animal_vacina->setUsuario($usuario);

    $data = AnimalVacinaDao::vacinar($animal_vacina);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});


$app->delete('/animais_vacinas/{anv_int_codigo}', function (Request $request, Response $response) {
	$anv_int_codigo = $request->getAttribute('anv_int_codigo');
    
    $animal_vacina = new AnimalVacina();
    $animal_vacina->setAnv_int_codigo($anv_int_codigo);

    $data = AnimalVacinaDao::delete($animal_vacina);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});