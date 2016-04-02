<?php
function clearInt($data){
	return abs((int)$data);
}
function clearStr($data){
	global $link;
	return mysqli_real_escape_string($link, trim(strip_tags($data)));
}
function saveBasket(){
	global $basket;
	$basket = base64_encode(serialize($basket));
	setcookie('basket', $basket, 0x7FFFFFFF);
}
function basketInit(){
	global $basket, $count;
	if (!isset($_COOKIE['basket'])){
		$basket  = array('orderid' => uniqid());
		saveBasket();
	}else{
		$basket = unserialize(base64_decode($_COOKIE['basket']));
		// print_r($basket); exit;
		$count = count($basket) - 1;
	}
}
//функция из трех инструкций
function deleteItemFromBasket($id){
	global $basket;
	unset($basket[$id]);//удаляем элемент
	saveBasket();//пересохраняем корзину
}
function add2Basket($id, $q){
	global $basket;
	$basket[$id] = $q;
	saveBasket();
} 
function myBasket(){
	global $link, $basket;
	$goods = array_keys($basket);//выбираем все ключи(id)
	array_shift($goods);//вырезаем orderid
	$ids = implode(",", $goods);//склеиваем строку(id через ,)
	if(!$goods)
		return array();//возвращаем пустой массив
	$sql = "SELECT id, title, author, pubyear, price FROM catalog WHERE id IN ($ids)";
	if (!$result = mysqli_query($link, $sql))
		return false;
	$items = result2Array($result);
	mysqli_free_result($result);
	return $items;
}
//$result переводим в массив
function result2Array($data){
   	global $basket;
	$arr = array();//создаем промежуточный массив
	while($row = mysqli_fetch_assoc($data)){
		$row['quantity'] = $basket[$row['id']];//добавляем параметр quantity   
		$arr[] = $row;
	}
	return $arr;
}  
function addItemToCatalog($title, $author, $pubyear, $price){
	global $link;
	$sql = "INSERT INTO catalog(title, author, pubyear, price) VALUES(?, ?, ?, ?)";
	if(!$stmt = mysqli_prepare($link, $sql))
	return false;
	mysqli_stmt_bind_param($stmt, "ssii", $title, $author, $pubyear, $price);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt); 
	return true; 			
}
function saveOrder($dt){
	global $link, $basket;
	$goods = myBasket();
	$stmt = mysqli_stmt_init($link);
	$sql = "INSERT INTO orders(title, author, pubyear, price, quantity, orderid, datetime) VALUES  (?, ?, ?, ?, ?, ?, ?)";
	if(!mysqli_stmt_prepare($stmt, $sql))
		return false;
	foreach ($goods as $item){
	mysqli_stmt_bind_param($stmt, 'ssiiisi', $item['title'], $item['author'], $item['pubyear'], $item['price'], $item['quantity'], $basket['orderid'], $dt);
	mysqli_stmt_execute($stmt);
}
	mysqli_stmt_close($stmt);
	setcookie('basket', '', time()-3600);
	return true;
}
function getOrders() {
	global $link;
	if(!is_file(ORDERS_LOG))//проверяем, есть ли заказы
		return false;
	$orders = file(ORDERS_LOG);//считываем данные файла
	$allorders = array();//начало верховного массива
	foreach ($orders as $order) {
		list($n, $e, $p, $a, $oid, $dt)=explode('|', $order);
		$orderinfo = array();//начало вывода массива инфо
		$orderinfo['name'] = $n;
		$orderinfo['email'] = $e;
		$orderinfo['phone'] = $p;
		$orderinfo['address'] = $a;
		$orderinfo['orderid'] = $oid;
		$orderinfo['dt'] = $dt;
		$sql = "SELECT title, author, pubyear, price, quantity FROM orders WHERE orderid = '$oid'";
		if(!$result = mysqli_query($link, $sql))
		return false;
		$items = array();
		while($row = mysqli_fetch_assoc($result)) {
		$items[] = $row;
		}
	 	mysqli_free_result($result);
	 	$orderinfo['goods']	= $items;
		$allorders[] = $orderinfo;//конец массива инфо
	}
	return $allorders;//конец верховного массива

}
function selectAllItems(){
	global $link;
	$sql = 'SELECT id, title, author, pubyear, price FROM catalog';
	if(!$result = mysqli_query($link, $sql))
		return false;
	$items = array();
	while($row = mysqli_fetch_assoc($result)) {
		$items[] = $row;
	}
	mysqli_free_result($result);
	return $items;
}
 
	