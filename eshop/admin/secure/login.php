<?
$title = 'Авторизация';
$login = '';
session_start();
header("HTTP/1.0 401 Unautorized");
require_once "secure.inc.php";
if($_SERVER['REQUEST_METHOD']=='POST'){
	$login = trim(strip_tags($_POST["login"]));
	$pw = trim(strip_tags($_POST["pw"]));
	$ref = trim(strip_tags($_GET["ref"]));
	
if(!$ref)
	$ref = '/admin/';
if($login and $pw){
	if($result = userExists($login)){

		list($_, $hash) = explode(':', $result);
		if(checkHash($pw, $hash)){
			$_SESSION['admin'] = true;
			
			 header("Location: $ref");
			
		}else{
			$title = '!Неправильное имя пользователя или пароль';
		}
	}else{
		$title = 'Неправильное имя пользователя или пароль';
		}
}else{
	$title = 'Заполните все поля формы!';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Авторизация</title>
</head>
<body>
	<h1><?=$title?></h1>
	<form action="<?= $_SERVER['REQUEST_URI']?>" method="post">
<div>
	<label for="txtUser">Логин</label>
	<input type="text" id="txtUser" name="login" value="<?= $login?>" />
</div>
<div>
	<label for="txtString">Пароль</label>
	<input type="text" id="txtString" name="pw" />
</div>
<div>
	<button type="submit">Войти</button>
</div>
	</form>
</body>
</html>