<?php
//подключение библиотек
require "inc/lib.inc.php";
require "inc/db.inc.php";
$n = clearStr($_POST['name']);
$p = clearStr($_POST['phone']);
$e = clearStr($_POST['email']);
$a = clearStr($_POST['address']);
$oid = $basket['orderid'];
$dt = time();
$order = "$n|$e|$p|$a|$oid|$dt\n";
file_put_contents('admin/'.ORDERS_LOG, $order, FILE_APPEND);
saveOrder($dt);
?>

<html>
<head>
	<title>Сохранение данных заказа</title>
</head>
<body>
	<p>Ваш заказ принят.</p>
	<p><a href="catalog.php">Вернуться в каталог товаров</a></p>
</body>
</html>