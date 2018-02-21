<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

//configurações de rotas
$app->get('/', function() {
    $page = new Page();
    $page->setTpl("index");

});

$app->get('/admin', function() {
	User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("index");

});

$app->get('/admin/login', function(){
	$page = new PageAdmin([
		"header"=>false,    //desabilitando o header e footer padrões
		"footer"=>false
	]);
	$page->setTpl("login");
});

$app->post('/admin/login', function(){
	User::login($_POST["login"], $_POST["password"]);

	header("Location: /ecommerce/admin");
	exit;
});

$app->get('/admin/logout', function(){
	User::logout();

	header("Location: /ecommerce/admin/login");
	exit;
});

//-------Começo do CRUD---------//
$app->get('/admin/users', function(){
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("users");
});

$app->get('/admin/users/create', function(){
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("users-create");
});

$app->get('/admin/users/:iduser', function(){
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("users-update");
});

$app->post('/admin/users/:iduser', function($iduser){
	User::verifyLogin();

});

$app->delete("/admin/users/:iduser", function($iduser){
	User::verifyLogin();
	
});
//-------Fim do CRUD---------//
$app->run();

