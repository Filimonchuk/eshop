<?
//подключение библиотек
require_once "secure/session.inc.php";
require_once "secure/secure.inc.php";
if(isset($_GET['logout'])){
	logOut();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>eshop</title>
</head>
<body>
	<h1>Администрирование магазина</h1>
	<h2>Доступные действия:</h2>
	<ul>
		<li><a href="add2cat.php">Добавление товаров в каталог</a></li>
		<li><a href="orders.php">Просмотр готовых заказов</a></li>
		<li><a href="secure/create_user.php">Добавить пользователя</a></li>
		<li><a href="index.php?logout">Завершить сеанс</a></li>
	</ul>
</body>
</html>