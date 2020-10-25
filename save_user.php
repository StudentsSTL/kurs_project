<meta charset="utf-8">
<?php

//заносим введенный пользователем пароль в переменную $FamPrep, если он пустой, то уничтожаем переменную
	if (isset($_POST['fam_pas'])) {
	$fam_pas=$_POST['fam_pas'];
	if ($fam_pas =='') { 
	unset($fam_pas);
	} 
	}

//заносим введенный пользователем пароль в переменную $FamPrep, если он пустой, то уничтожаем переменную
	if (isset($_POST['name_pas'])) {
	$name_pas=$_POST['name_pas'];
	if ($name_pas =='') { 
	unset($name_pas);
	} 
	}

//заносим введенный пользователем пароль в переменную $FamPrep, если он пустой, то уничтожаем переменную
	if (isset($_POST['otch_pas'])) {
	$otch_pas=$_POST['otch_pas'];
	if ($otch_pas =='') { 
	unset($otch_pas);
	} 
	}

	if (isset($_POST['data_rog'])) {
	$data_rog=$_POST['data_rog'];
	if ($data_rog =='') { 
	unset($data_rog);
	} 
	}

	if (isset($_POST['sex'])) {
	$sex=$_POST['sex'];
	if ($sex =='') { 
	unset($sex);
	} 
	}

	if (isset($_POST['ser_pasport'])) {
	$ser_pasport=$_POST['ser_pasport'];
	if ($ser_pasport =='') { 
	unset($ser_pasport);
	} 
	}

	if (isset($_POST['nom_pasport'])) {
	$nom_pasport=$_POST['nom_pasport'];
	if ($nom_pasport =='') { 
	unset($nom_pasport);
	} 
	}

 //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
	if (isset($_POST['login'])) {
	$login = $_POST['login']; 
	if ($login == '') {
	unset($login);
	} 
	}

//заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
	if (isset($_POST['pass'])) {
	$pass=$_POST['pass'];
	if ($pass =='') { 
	unset($pass);
	} 
	}


//если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
	if (empty($login)  or empty($pass) or empty($fam_pas) or empty($name_pas) or empty($otch_pas) or empty($data_rog) or empty($sex) or empty($ser_pasport) or empty($nom_pasport)) 
	{
	exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
	
	}



//если логин и пароль введены, то обрабатываем их, чтобы теги и скрипты не работали
	$fam_pas = stripslashes($fam_pas);
	$fam_pas = htmlspecialchars($fam_pas);
	$name_pas = stripslashes($name_pas);
	$name_pas = htmlspecialchars($name_pas);
	$otch_pas = stripslashes($otch_pas);
	$otch_pas = htmlspecialchars($otch_pas);
	$data_rog = stripslashes($data_rog);
	$data_rog = htmlspecialchars($data_rog);
	$sex = stripslashes($sex);
	$sex = htmlspecialchars($sex);
	$ser_pasport = stripslashes($ser_pasport);
	$ser_pasport = htmlspecialchars($ser_pasport);
	$nom_pasport = stripslashes($nom_pasport);
	$nom_pasport = htmlspecialchars($nom_pasport);
	$login = stripslashes($login);
	$login = htmlspecialchars($login);
	$pass = stripslashes($pass);
	$pass = htmlspecialchars($pass);
//удаляем лишние пробелы
	$fam_pas = trim($fam_pas);
	$name_pas = trim($name_pas);
	$otch_pas = trim($otch_pas);
	$data_rog = trim($data_rog);
	$sex = trim($sex);
	$ser_pasport = trim($ser_pasport);
	$nom_pasport = trim($nom_pasport);
	$login = trim($login);
	$pass = trim($pass);

// подключаемся к базе
	include ("bd.php");

// проверка на существование пользователя с таким же логином
	$result = mysql_query("SELECT id_us FROM Users WHERE Users.login='$login'",$db);
	$myrow = mysql_fetch_array($result);
	if (!empty($myrow['id_us'])) {
	exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин.");
	}

 // если такого нет, то сохраняем данные
	$result2 = mysql_query ("INSERT INTO Aero.Users (Users.login,Users.pass,Users.id_lvl) VALUES('$login','$pass','2')");
	$id_us = mysql_query("SELECT * FROM Aero.Users order by id_us DESC");
	$id_us = mysql_fetch_array($id_us);
	$result3 = mysql_query("INSERT INTO Aero.passegers (fam_pas,name_pas,otch_pas,data_rog,sex,ser_pasport,nom_pasport,id_us) VALUES('$fam_pas','$name_pas','$otch_pas','$data_rog','$sex','$ser_pasport','$nom_pasport','$id_us[id_us]')");
// Проверяем, есть ли ошибки
	if (($result2=='TRUE') and ($result3=='TRUE'))
	{
	echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт. <a href='index.php'>Главная страница</a>";
	}
 	else {
	echo "Ошибка! Вы не зарегистрированы.";
	}
?>