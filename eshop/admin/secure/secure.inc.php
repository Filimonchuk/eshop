<?
//константа для хранения пользователей
const FILE_NAME = ".htpasswd";
//функция, которая возвращает хеш 
function getHash($password) {  
	$hash = password_hash($password, PASSWORD_BCRYPT);
	return trim($hash);
}
//функция проверки пароля
function checkHash($password, $hash) {
	return password_verify(trim($password), trim($hash));
}
//запись в файл строки с данными пользователя
function saveUser($login, $hash) {
	$str = "$login:$hash\n";
	if(file_put_contents(FILE_NAME, $str, FILE_APPEND))
		return true;
	else
		return false;
} 
//функция проверки пользователя
function userExists($login){
if(!is_file(FILE_NAME))//есть ли файл
	return false;
	$users = file(FILE_NAME);//зачитываем файл в массив
	foreach($users as $user){
		if(strpos($user, $login.':') !== false)
			return $user;//возвращаем найденного пользователя строкой логин:хеш
	}
	return false;//пользователь не найден 
}
//функция завершения сессии
function logOut(){
	session_destroy();
	header('Location: secure/login.php');
}