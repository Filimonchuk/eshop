<?
require "secure/session.inc.php";
// require "../inc/db.inc.php"; выдает ошибку(неизвестная функция basketInit в db.inc.php 13строка)
?>
<html>
	<head>
		<title>Форма добавления товаров в каталог</title>
	</head>
	<body>
		<form action="save2cat.php" method="post">
			<p>Название: <input type="text" name="title" size="100">
			<p>Автор: <input type="text" name="author" size="50">
			<p>Год издания: <input type="text" name="pubyear" size="4">
			<p>Цена: <input type="text" name="price" size="6">грн.
			<p><input type="submit" value="Добавить">
		</form>
	</body>
</html>