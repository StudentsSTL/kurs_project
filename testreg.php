<?php
//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
	session_start();

	if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
	if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} } //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
  
	if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
	{
		echo "<script> alert ('Invalid user name or password entered.') </script>";
		exit("<meta http-equiv='refresh' content='0; url=index.php' >");
	}

//если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
	$login = stripslashes($login);
	$login = htmlspecialchars($login);
	$password = stripslashes($password);
	$password = htmlspecialchars($password);

//удаляем лишние пробелы
	$login = trim($login);
	$password = trim($password);

// подключаемся к базе
	include ("bd.php"); 
 
//извлекаем из базы все данные о пользователе с введенным логином
	$result = mysql_query("SELECT * FROM Aero.Users WHERE Users.login='$login'",$db); 
	$myrow = mysql_fetch_array($result);
	if (empty($myrow['login'])) {
//если пользователя с введенным логином не существует
	echo "<script> alert ('Invalid user name or password entered.') </script>";
	exit("<meta http-equiv='refresh' content='0; url=index.php' >");
	}
	else {
//если существует, то сверяем пароли и уровень доступа
	if (($myrow['id_lvl'] == 1) and ($myrow['pass']===$password)){
		echo "<script> alert ('Congratulations, you enterned.') </script>";
		exit("<meta http-equiv='refresh' content='0; url= aero.php'>");
	}
	if ($myrow['pass']===$password) {
//если пароли совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
	$_SESSION['us_login']=$myrow['login']; 
	$_SESSION['id_us']=$myrow['id_us'];//эти данные очень часто используются, вот их и будет "носить с собой" вошедший пользователь
	$r1 = mysql_query("SELECT id_pas, fam_pas, name_pas, otch_pas FROM passegers WHERE passegers.id_us = ".$myrow['id_us']);
	$myrow1=mysql_fetch_array($r1);
	$_SESSION['id_pas'] = $myrow1['id_pas'];
	$_SESSION['fam_pas'] = $myrow1['fam_pas'];
	$_SESSION['name_pas'] = $myrow1['name_pas'];
	$_SESSION['otch_pas'] = $myrow1['otch_pas'];
	echo "<script> alert ('Congratulations, you enterned.') </script>";
	exit("<meta http-equiv='refresh' content='0; url= main.php'>");
	}
	else {
//если пароли не сошлись
	echo "<script> alert ('Invalid user name or password entered.') </script>";
	exit("<meta http-equiv='refresh' content='0; url=index.php' >");
	}
	}
?>