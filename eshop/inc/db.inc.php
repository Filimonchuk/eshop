<?php
header('Content-Type: text/html; charset=utf-8');
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'u322196114_feel');
define('DB_PASSWORD', '11390746');
define('DB_NAME', 'u322196114_eshop');
define('ORDERS_LOG', 'orders.log');
/*корзина покупателя*/
$basket = array();
/*кол-во товаров в корзине*/	
$count = 0;
$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
basketInit();