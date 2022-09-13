<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/system/config.php";

$app = new \Slim\app();

//HomeController - GET
$app->get('/', '\DEV\Controllers\HomeController:login');
$app->get('/feed', '\DEV\Controllers\HomeController:feed');
$app->get('/feed/{usuario:[a-zA-Z0-9-_]+}', '\DEV\Controllers\HomeController:feed_usuario');
$app->get('/configuracao', '\DEV\Controllers\HomeController:configuracao');
$app->get('/pesquisa', '\DEV\Controllers\HomeController:pesquisa');
$app->get('/mensagens', '\DEV\Controllers\HomeController:mensagens');
$app->get('/fotos', '\DEV\Controllers\HomeController:fotos');

//UsuarioController - GET
$app->get('/logout', '\DEV\Controllers\UsuarioController:logout');

//UsuarioController - POST
$app->post('/cadastrar', '\DEV\Controllers\UsuarioController:cadastrar');
$app->post('/login', '\DEV\Controllers\UsuarioController:login_usuario');
$app->post('/quem_sou_eu', '\DEV\Controllers\UsuarioController:quem_sou_eu');
$app->post('/configuracao', '\DEV\Controllers\UsuarioController:configuracao');

//MensagemController - POST
$app->post('/nova_mensagem', '\DEV\Controllers\MensagemController:nova_mensagem');
$app->post('/getMensagens', '\DEV\Controllers\MensagemController:getMensagens');


//PublicacaoContoller - POST
$app->post('/publicar', '\DEV\Controllers\PublicacaoController:publicar');
$app->post('/getPublicacoes', '\DEV\Controllers\PublicacaoController:getPublicacoes');


$app->run();

?>