<?php
//подключение библиотек
require "session.inc.php";
require "secure.inc.php";
?>
<html>
<head>
	<title>Создание пользователя</title>
	<meta charset="UTF-8">
</head>
<body>
	<h1>Создание пользователя</h1>
	<?
$login = 'root';//Значения по умолчанию
$password = '1234';//Значения по умолчанию
$result = '';//Значения по умолчанию

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$login = $_POST['login'] ?: $login;
	if(!userExists($login)){
		$password = $_POST['password'] ?: $password;
		$hash = getHash($password);
		if(saveUser($login, $hash))
			$result = 'Хеш'.$hash.'успешно добавлен в файл';
		else
			$result = 'При записи хеша'.$hash.'произошла ошибка';
	}else{
		$result = 'Пользователь'.$login.'существует. Выберите другое имя';

	}
}
	?>
	<h3><?= $result?></h3>
	<form action="<?= $_SERVER['PHP_SELF']?>" method="post">
<div>
	<label for="txtUser">Логин</label>
	<input type="text" id="txtUser" name="login" value="<?= $login?>" />
</div>
<div>
	<label for="txtString">Пароль</label>
	<input type="text" id="txtString" name="password" value="<?= $password?>" />
</div>
<div>
	<button type="submit">Создать</button>
</div>
	</form>
</body>
</html>