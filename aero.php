<?php 
if (isset($_POST['exsl'])){
  header('Content-Type: application/vnd.ms-excel; charset=utf-8');
  header("Content-Disposition: attachment;filename=".date("d-m-Y")."-export.xls");
  header("Content-Transfer-Encoding: binary ");
  include ('bd.php');
  echo '
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <meta name="author" content="zabey" />
   <title>Demo</title>
 </head>
 <body>';

// !!! Таблица с данными
$result1 = mysql_query("SELECT  marshrut.otpr_place, marshrut.naz_place, marshrut.kilomtrge, reises.put_time, samolets.tip_samolet, samolets.vmestimost 
FROM marshrut, reises, samolets 
WHERE (marshrut.id_marsh = reises.id_marsh) and (reises.id_samolet = samolets.id_samolet) and (reises.id_reis = ".$_POST[Reises].")");
$myrow1= mysql_fetch_array($result1);
$myrow2 = mysql_fetch_array(mysql_query("SELECT  COUNT(tickets.id_ticket) FROM tickets, reises WHERE (tickets.id_reis = reises.id_reis) and (reises.id_reis= ".$_POST[Reises].")"));
$myrow3 = mysql_fetch_array(mysql_query("SELECT  SUM(bagage.ves_bag) FROM bagage, reises, tickets, passegers WHERE (bagage.id_pas = passegers.id_pas) and (tickets.id_pas = passegers.id_pas) and (tickets.id_reis = reises.id_reis) and (reises.id_reis= ".$_POST[Reises].")"));
echo "<table class='tab'>";
 echo "<tr>";
 echo "<th colspan='7' align='center'>Показатели рейса а/к Аэрофлот по этапам полета</th>";
 echo "</tr>";
 echo "<tr>";
 echo "<th colspan='2'>Этапы полета</th>";
 echo "<th rowspan='2'>Расстояние <br>этапа(км)</th>";
 echo "<th rowspan='2'>Время <br>полета (час)</th>";
 echo "<th rowspan='2'>Тип самолета</th>";
 echo "<th rowspan='2'>Предельное <br>кол-во кресел</th>";
 echo "<th colspan='2'>Перевозки на этапе полета</th>";
 echo "</tr>";
 echo "<tr>";
 echo "<th>Город вылета</th>";
 echo "<th>Город посадки</th>";
 echo "<th>Пассажиры (чел.)</th>";
 echo "<th>Вес багажа (кг)</th>";
 echo "</tr>";
 echo "<tr valigin='midle'>";
 echo "<td align='center'>$myrow1[otpr_place]</td>";
 echo "<td align='center'>$myrow1[naz_place]</td>";
 echo "<td align='center'>$myrow1[kilomtrge]</td>";
 echo "<td align='center'>$myrow1[put_time]</td>";
 echo "<td align='center'>$myrow1[tip_samolet]</td>";
 echo "<td align='center'>$myrow1[vmestimost]</td>";
 echo "<td align='center'>$myrow2[0]</td>";
 echo "<td align='center'>$myrow3[0]</td>";
 echo "</tr>";
 echo "</table>";
echo '</body></html>';
};
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>AeroDB</title>
    <link rel="stylesheet" href="css/aero.css">
</head>
<body>
	<div class="menu">
		<button class="tablinks" onclick="tableAdmin(event, 'bagage')" id="defaultOpen">Багаж</button>
		<button class="tablinks" onclick="tableAdmin(event, 'lvl_pass')">Уровень доступа</button>
		<button class="tablinks" onclick="tableAdmin(event, 'marshrut')">Маршруты</button>
		<button class="tablinks" onclick="tableAdmin(event, 'passegers')">Пассажиры</button>
		<button class="tablinks" onclick="tableAdmin(event, 'pilot')">Пилоты</button>
		<button class="tablinks" onclick="tableAdmin(event, 'reises')">Рейсы</button>
		<button class="tablinks" onclick="tableAdmin(event, 'samolets')">Самолеты</button>
		<button class="tablinks" onclick="tableAdmin(event, 'tickets')">Билеты</button>
		<button class="tablinks" onclick="tableAdmin(event, 'Users')">Пользователи</button>
        <button class="tablinks" onclick="tableAdmin(event, 'InfoReis')">Отчет о рейсе</button>
        <a href="index.php"><button>Выход</button></a>
	</div>

	<div id="bagage" class="tabcontent">
      <h3>Таблица "Багаж"</h3>
      <p>Таблица, в которую заносятся данные о багаже пассажиров</p>
    <form method="POST">
    <input type="submit" name="del1" value="Delete" class="button">  <!-- Создание кнопки удаления -->
    <input type="submit" name="save1" value="Save" class="button"> 
        
      <?
        include ('bd.php');

        $r=mysql_query("select * from bagage");
        $myrow=mysql_fetch_array($r);
        echo "<br>";
        echo "<table border='1' cellspacing='0' cellpadding='4' class='tab'>";
        echo "<tr>";
        echo "<th align='center'>ID Багажа</th>";
        echo "<th align='center'>Тип багажа</th>";
		echo "<th align='center'>Вес багажа</th>";
		echo "<th align='center'>Высота багажа</th>";
        echo "<th align='center'>Ширина багажа</th>";
        echo "<th align='center'>Длина багажа</th>";
        echo "<th align='center' style='width:280px'>ФИО Пассажира</th>";
        echo "<th align='center'></th>";
        echo "</tr>";

        do {
            $id_bag=$myrow['id_bag'];
            $tip_bag=$myrow['tip_bag'];
            $ves_bag=$myrow['ves_bag'];
            $vis_bag=$myrow['vis_bag'];
            $shir_bag=$myrow['shir_bag'];
			$dlina_bag=$myrow['dlina_bag'];
			$id_pas=$myrow['id_pas'];

            echo "<tr>";
            echo "<td align='center'><input type='text' style='width:50px' name='id_bag[$id_bag]' value='$id_bag'></td>";
            echo "<td align='center'><input type='text' style='width:150px' name='tip_bag[$id_bag]' value='$tip_bag'></td>";
            echo "<td align='center'><input type='text' style='width:120px' name='ves_bag[$id_bag]' value='$ves_bag'></td>";
            echo "<td align='center'><input type='text' style='width:120px' name='vis_bag[$id_bag]' value='$vis_bag'></td>";
            echo "<td align='center'><input type='text' style='width:120px' name='shir_bag[$id_bag]' value='$shir_bag'></td>";
			echo "<td align='center'><input type='text' style='width:120px' name='dlina_bag[$id_bag]' value='$dlina_bag'></td>";
			echo "<td>";
            $result1=mysql_query("Select * FROM passegers");  //Запрос на вывод всех данных из таблицы Student
            echo "<select class='select_key' name='Passegers[$id_bag]' >";       //Создание селекта
            do {                                          
                echo "<option ";                          //Создание пункта
                if ($myrow[id_pas] == $id_pas){          //ЕСЛИ ID_Test = выбранному тесту, то он будет выбранный
                    echo "selected ";                     //Выбрать элемент
                } 
                echo "value=$myrow[id_pas]>$myrow[fam_pas] $myrow[name_pas] $myrow[otch_pas]</option>"; //Вывод данных
            }
            while($myrow=mysql_fetch_array($result1));
            echo "</select></td>";  #Закрытие выпадающего списка и закрытие ячейки 
            echo "<td align='center'><input style='width:20px' name='id[$id_bag]' type='checkbox' value='$id_bag'></td>";
            echo "</tr>";
        }

        while ($myrow=mysql_fetch_array($r));

        //Сохранение
if(isset($_POST['save1'])){ #Проверка на нажатие кнопки
    foreach($_POST['id_bag'] as $key => $value){
        $sql="update bagage set id_bag='".$value."' WHERE id_bag=".$key; #Изменение id-st из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['tip_bag'] as $key1 => $value1){
        $sql="update bagage set tip_bag='".$value1."' WHERE id_bag=".$key1; #Изменение FamSt из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['ves_bag'] as $key2 => $value2){
        $sql="update bagage set ves_bag='".$value2."' WHERE id_bag=".$key2; #Изменение NameSt из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
     foreach($_POST['vis_bag'] as $key3 => $value3){
        $sql="update bagage set vis_bag='".$value3."' WHERE id_bag=".$key3; #Изменение Otch из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['shir_bag'] as $key4 => $value4){
        $sql="update bagage set shir_bag='".$value4."' WHERE id_bag=".$key4; #Изменение LoginSt из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['dlina_bag'] as $key5 => $value5){
        $sql="update bagage set dlina_bag='".$value5."' WHERE id_bag=".$key5; #Изменение PassSt из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['Passegers'] as $key6 => $value6){
        $sql="update bagage set id_pas='".$value6."' WHERE id_bag=".$key6; #Изменение id_gr из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
};
//Удаление
if(isset($_POST['del1'])){  #Проверка на нажатие кнопки
    foreach($_POST['id'] as $key7 => $value7){
        $sql="Delete FROM bagage WHERE id_bag=".$value7; //В ином случа сразу удалить студента
        mysql_query($sql); #Выполнение запроса
  }
      echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
};
?>

</form>

<form method="POST" action="">
    <tr>
        <td>Autho_inc</td> 
        <td> <input name="tip_bag" type="text" placeholder="Your data"/>                     <!--Формирование текстового поля-->
        <td> <input name="ves_bag" type="text" placeholder="Your data"/>                    <!--Формирование текстового поля-->
        <td> <input name="vis_bag" type="text"  placeholder="Your data"/>                     <!--Формирование текстового поля-->
        <td> <input name="shir_bag" type="text" placeholder="Your data"/>                   <!--Формирование текстового поля-->
        <td> <input name="dlina_bag" type="text" placeholder="Your data"/>     
                 <!--Формирование текстового поля-->

<? 
$resul1=mysql_query("Select * FROM passegers");  //Запрос на вывод всех данных из таблицы Student
            echo "<td><select class='select_key' name='Passegers'>";       //Создание селекта
            while($myrow1=mysql_fetch_array($resul1)){                                          
                echo "<option value = $myrow1[id_pas]> $myrow1[fam_pas] $myrow1[name_pas] $myrow1[otch_pas]</option>"; //Вывод данных
            };
            
            echo "</select></td>";  #Закрытие выпадающего списка и закрытие ячейки 
?> 
 <td> <input type="submit" value="Add" name="otpravit1" class="button"/> <!-- Создание кнопки добавить -->
    </tr>
</table> 
 <?
if(isset($_POST['otpravit1'])){ #Проверка на нажатие кнопки 
//переменные

 $tipbag=$_POST['tip_bag'];
 $vesbag=$_POST['ves_bag'];
 $visbag=$_POST['vis_bag'];
 $shirbag=$_POST['shir_bag'];
 $dlinabag=$_POST['dlina_bag'];
 $Passegers=$_POST['Passegers'];

//запрос на добавление данных в таблицу Student
 $result = mysql_query("INSERT INTO bagage (id_bag,tip_bag,ves_bag,vis_bag,shir_bag,dlina_bag, id_pas) VALUES ('','$tipbag','$vesbag','$visbag','$shirbag','$dlinabag','$Passegers')");
 if ($result == true){  #Проверка на добавление
    echo"<script> window.location = 'aero.php' </script>"; #Перезапуск страницы
}else{
    echo "<script> alert (' Not all data entered ')</script>"; #Вывод алерта о неполном вводе данных
}
}
 ?>
  </form> <!-- Закрытие формы (кнопки) -->
</div>
</div>
	
	<div id="lvl_pass" class="tabcontent">
      <h3>Таблица "Уровень доступа"</h3>
      <p>Таблица с описанием уровней доступа к сайту</p> 
      <form method="POST">
    <input type="submit" name="del2" value="Delete" class="button">  <!-- Создание кнопки удаления -->
    <input type="submit" name="save2" value="Save" class="button"> 
      <?
        include ('bd.php');

        $q=mysql_query("select * from lvl_pass");
        $myrow=mysql_fetch_array($q);
        echo "<br>";
        echo "<table border='1'  cellspacing='0' cellpadding='4' class='tab'>";
        echo "<tr>";
        echo "<th align='center'>ID Уровня</th>";
        echo "<th align='center'>Наименование</th>";
        echo "<th align='center'></th>";
        echo "</tr>";

        do {
            $id_lvl=$myrow['id_lvl'];
            $naimen_lvl=$myrow['naimen_lvl'];

            echo "<tr>";
            echo "<td align='center'><input style='width:50px' type='text' name='id_lvl[$id_lvl]' value='$id_lvl'></td>";
            echo "<td align='center'><input style='width:150px' type='text' name='naimen_lvl[$id_lvl]' value='$naimen_lvl'></td>";
            echo "<td align='center'><input style='width:20px' name='id[$id_lvl]' type='checkbox' value='$id_lvl'></td>";
            echo "</tr>";
        }

        while ($myrow=mysql_fetch_array($q));

        if(isset($_POST['save2'])){ #Проверка на нажатие кнопки
            foreach($_POST['id_lvl'] as $key => $value){
                $sql="update lvl_pass set id_lvl='".$value."' WHERE id_lvl=".$key; #Изменение id-st из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['naimen_lvl'] as $key1 => $value1){
                $sql="update lvl_pass set naimen_lvl='".$value1."' WHERE id_lvl=".$key1; #Изменение FamSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        //Удаление
        if(isset($_POST['del2'])){  #Проверка на нажатие кнопки
            foreach($_POST['id'] as $key7 => $value7){
                $result = mysql_query("SELECT * FROM Users WHERE id_lvl=".$value7);
                if ($result){
                    do{
                        $result2 = mysql_query("SELECT * FROM passegers WHERE id_us = ".$myrow['id_us']);
                        do{

                            mysql_query("DELETE FROM tickets WHERE id_pas = ".$myrow2['id_pas']);
                            mysql_query("DELETE FROM bagage WHERE id_pas = ".$myrow2['id_pas']);

                        }while($myrow2 = mysql_fetch_array($result2));
                        mysql_query("DELETE FROM passegers where id_us = ".$myrow['id_us']);

                    } while($myrow = mysql_fetch_array($result));
                    mysql_query("DELETE FROM Users where id_lvl = ".$value7);
                    mysql_query("DELETE FROM lvl_pass where id_lvl = ".$value7);
                };
          }
              echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        ?>
        </form>
        
        <form method="POST" action="">
            <tr>
                <td>Autho_inc</td> 
                <td> <input name="naimen_lvl" type="text" placeholder="Your data"/>                     <!--Формирование текстового поля-->    
                         <!--Формирование текстового поля-->
         <td> <input type="submit" value="Add" name="otpravit2" class="button"/> <!-- Создание кнопки добавить -->
            </tr>
        </table> 
         <?
        if(isset($_POST['otpravit2'])){ #Проверка на нажатие кнопки 
        //переменные
        
         $naimenlvl=$_POST['naimen_lvl'];
        
        //запрос на добавление данных в таблицу Student
         $result = mysql_query("INSERT INTO lvl_pass (id_lvl,naimen_lvl) VALUES ('','$naimenlvl')");
         if ($result == true){  #Проверка на добавление
            echo"<script> window.location = 'aero.php' </script>"; #Перезапуск страницы
        }else{
            echo "<script> alert (' Not all data entered ')</script>"; #Вывод алерта о неполном вводе данных
        }
        }
         ?>
          </form> <!-- Закрытие формы (кнопки) -->
        </div>
        </div>
	
	<div id="marshrut" class="tabcontent">
      <h3>Таблица "Маршрут"</h3>
      <p>Таблица, в которую заносятся данные о маршрутах</p>
      <form method="POST">
      <input type="submit" name="del3" value="Delete" class="button">  <!-- Создание кнопки удаления -->
      <input type="submit" name="save3" value="Save" class="button">  
      <?
        include ('bd.php');

        $r=mysql_query("select * from marshrut");
        $myrow=mysql_fetch_array($r);
        echo "<br>";
        echo "<table border='1'  cellspacing='0' cellpadding='4' class='tab'>";
        echo "<tr>";
        echo "<th align='center' style='width:30px'>ID Маршрута</th>";
        echo "<th align='center' style='width:200px'>Киллометраж</th>";
		echo "<th align='center' style='width:200px'>Пункт отправления</th>";
        echo "<th align='center' style='width:200px'>Пункт прибытия</th>";
        echo "<th align='center' style='width:60px'></th>";
        echo "</tr>";

        do {
            $id_marsh=$myrow['id_marsh'];
            $kilomtrge=$myrow['kilomtrge'];
            $otpr_place=$myrow['otpr_place'];
            $naz_place=$myrow['naz_place'];

            echo "<tr>";
            echo "<td align='center'><input type='text'  name='id_marsh[$id_marsh]' value='$id_marsh'></td>";
            echo "<td align='center'><input type='text' name='kilomtrge[$id_marsh]' value='$kilomtrge'></td>";
            echo "<td align='center'><input type='text' name='otpr_place[$id_marsh]' value='$otpr_place'></td>";
            echo "<td align='center'><input type='text' name='naz_place[$id_marsh]' value='$naz_place'></td>";
            echo "<td align='center'><input style='width:20px' name='id[$id_marsh]' type='checkbox' value='$id_marsh'></td>";
            echo "</tr>";
        }

        while ($myrow=mysql_fetch_array($r));

        if(isset($_POST['save3'])){ #Проверка на нажатие кнопки
            foreach($_POST['id_marsh'] as $key => $value){
                $sql="update marshrut set id_marsh='".$value."' WHERE id_marsh=".$key; #Изменение id-st из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['kilomtrge'] as $key1 => $value1){
                $sql="update marshrut set kilomtrge='".$value1."' WHERE id_marsh=".$key1; #Изменение FamSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['otpr_place'] as $key2 => $value2){
                $sql="update marshrut set otpr_place='".$value2."' WHERE id_marsh=".$key2; #Изменение NameSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
             foreach($_POST['naz_place'] as $key3 => $value3){
                $sql="update marshrut set naz_place='".$value3."' WHERE id_marsh=".$key3; #Изменение Otch из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }

            echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        //Удаление
        if(isset($_POST['del3'])){  #Проверка на нажатие кнопки
            foreach($_POST['id'] as $key7 => $value7){
                $result = mysql_query("SELECT * FROM reises WHERE id_marsh = ".$value7);
                if ($result){

                    do{
                      mysql_query("DELETE FROM tickets WHERE id_reis=".$myrow['id_reis']);
                    } while($myrow = mysql_fetch_array($result));
                    mysql_query("DELETE FROM reises where id_marsh=".$value7);
                    mysql_query("DELETE FROM marshrut where id_marsh=".$value7);
                };
          }
              echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        ?>
        
        </form>
        
        <form method="POST" action="">
            <tr>
                <td align="center">Autho_inc</td> 
                <td align="center"> <input name="kilometrge" type="text" placeholder="Your data"/>                     <!--Формирование текстового поля-->
                <td align="center"> <input name="otpr_place" type="text" placeholder="Your data"/>                    <!--Формирование текстового поля-->
                <td align="center"> <input name="naz_place" type="text"  placeholder="Your data"/>                     <!--Формирование текстового поля-->     
                         <!--Формирование текстового поля-->
         <td align="center"> <input type="submit" value="Add" name="otpravit3" class="button"/> <!-- Создание кнопки добавить -->
            </tr>
        </table> 
         <?
        if(isset($_POST['otpravit3'])){ #Проверка на нажатие кнопки 
        //переменные
        
         $kilomtrage=$_POST['kilomtrge'];
         $otprplace=$_POST['otpr_place'];
         $nazplace=$_POST['naz_place'];
    
        
        //запрос на добавление данных в таблицу Student
         $result = mysql_query("INSERT INTO marshrut (id_marsh,kilomtrge,otpr_place,naz_place) VALUES ('','$kilomtrage','$otprplace','$nazplace')");
         if ($result == true){  #Проверка на добавление
            echo"<script> window.location = 'aero.php' </script>"; #Перезапуск страницы
        }else{
            echo "<script> alert (' Not all data entered ')</script>"; #Вывод алерта о неполном вводе данных
        }
        }
         ?>
          </form> <!-- Закрытие формы (кнопки) -->
        </div>
        </div>

	<div id="passegers" class="tabcontent">
      <h3>Таблица "Пассажиры"</h3>
      <p>Таблица, в которую заносятся данные о пассажирах</p>
      <form method="POST">
    <input type="submit" name="del4" value="Delete" class="button">  <!-- Создание кнопки удаления -->
    <input type="submit" name="save4" value="Save" class="button"> 
      <?
        include ('bd.php');

        $r=mysql_query("select * from passegers");
        $myrow=mysql_fetch_array($r);
        echo "<br>";
        echo "<table border='1'  cellspacing='0' cellpadding='4' class='tab'>";
        echo "<tr>";
        echo "<th align='center' style='width:50px;'>ID Пассажира</th>";
        echo "<th align='center'>Фамилия</th>";
		echo "<th align='center'>Имя</th>";
		echo "<th align='center'>Отчество</th>";
        echo "<th align='center'>Дата рождения</th>";
        echo "<th align='center' style='width:70px;'>Пол</th>";
		echo "<th align='center'>Серия паспорта</th>";
		echo "<th align='center'>Номер паспорта</th>";
        echo "<th align='center'>Логин пользователя</th>";
        echo "<th align='center'></th>";
        echo "</tr>";

        do {
			$id_pas=$myrow['id_pas'];
            $fam_pas=$myrow['fam_pas'];
            $name_pas=$myrow['name_pas'];
            $otch_pas=$myrow['otch_pas'];
            $data_rog=$myrow['data_rog'];
			$sex=$myrow['sex'];
			$ser_pasport=$myrow['ser_pasport'];
			$nom_pasport=$myrow['nom_pasport'];
			$id_us=$myrow['id_us'];

            echo "<tr>";
			echo "<td style='width:50px' align='center'><input type='text' name='id_pas[$id_pas]' value='$id_pas'></td>";
            echo "<td align='center'><input type='text' name='fam_pas[$id_pas]' value='$fam_pas'></td>";
            echo "<td align='center'><input type='text' name='name_pas[$id_pas]' value='$name_pas'></td>";
            echo "<td align='center'><input type='text' name='otch_pas[$id_pas]' value='$otch_pas'></td>";
            echo "<td align='center'><input type='date' name='data_rog[$id_pas]' value='$data_rog'></td>";
            echo "<td align='center'><input type='text' name='sex[$id_pas]' value='$sex'></td>"; 
			echo "<td align='center'><input type='text' pattern='[0-9]{,4}' name='ser_pasport[$id_pas]' value='$ser_pasport'></td>";
			echo "<td align='center'><input type='text' pattern='[0-9]{,6}' name='nom_pasport[$id_pas]' value='$nom_pasport'></td>";
            echo "<td>";
            $result1=mysql_query("Select * FROM Users");  //Запрос на вывод всех данных из таблицы Student
            echo "<select class='select_key' name='Users[$id_pas]' >";       //Создание селекта
            do {                                          
                echo "<option ";                          //Создание пункта
                if ($myrow[id_us] == $id_us){          //ЕСЛИ ID_Test = выбранному тесту, то он будет выбранный
                    echo "selected ";                     //Выбрать элемент
                } 
                echo "value=$myrow[id_us]>$myrow[login]</option>"; //Вывод данных
            }
            while($myrow=mysql_fetch_array($result1));
            echo "</select></td>"; 
            echo "<td align='center'><input style='width:20px' name='id[$id_pas]' type='checkbox' value='$id_pas'></td>";
            echo "</tr>";
        }

        while ($myrow=mysql_fetch_array($r));

 //Сохранение
if(isset($_POST['save4'])){ #Проверка на нажатие кнопки
    foreach($_POST['id_pas'] as $key => $value){
        $sql="update passegers set id_pas='".$value."' WHERE id_pas=".$key; #Изменение id-st из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['fam_pas'] as $key1 => $value1){
        $sql="update passegers set fam_pas='".$value1."' WHERE id_pas=".$key1; #Изменение FamSt из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['name_pas'] as $key2 => $value2){
        $sql="update passegers set name_pas='".$value2."' WHERE id_pas=".$key2; #Изменение NameSt из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
     foreach($_POST['otch_pas'] as $key3 => $value3){
        $sql="update passegers set otch_pas='".$value3."' WHERE id_pas=".$key3; #Изменение Otch из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['data_rog'] as $key4 => $value4){
        $sql="update passegers set data_rog='".$value4."' WHERE id_pas=".$key4; #Изменение LoginSt из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['sex'] as $key5 => $value5){
        $sql="update passegers set sex='".$value5."' WHERE id_pas=".$key5; #Изменение PassSt из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['ser_pasport'] as $key6 => $value6){
        $sql="update passegers set ser_pasport='".$value6."' WHERE id_pas=".$key6; #Изменение id_gr из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['nom_pasport'] as $key6 => $value6){
        $sql="update passegers set nom_pasport='".$value6."' WHERE id_pas=".$key6; #Изменение id_gr из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    foreach($_POST['Users'] as $key6 => $value6){
        $sql="update passegers set id_us='".$value6."' WHERE id_pas=".$key6; #Изменение id_gr из таблицы Student
        mysql_query($sql); #Выполнение запроса
    }
    echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
};
//Удаление
if(isset($_POST['del4'])){  #Проверка на нажатие кнопки
    foreach($_POST['id'] as $key7 => $value7){
        mysql_query("DELETE FROM tickets WHERE id_pas=".$value7);
        mysql_query("DELETE FROM bagage WHERE id_pas=".$value7);
      mysql_query("DELETE FROM passegers WHERE id_pas=".$value7);

  }
  echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы    
};
      

?>

</form>

<form method="POST" action="">
    <tr align="center">
        <td>Autho_inc</td> 
        <td> <input name="fam_pas" type="text" placeholder="Your data"/>                     <!--Формирование текстового поля-->
        <td> <input name="name_pas" type="text" placeholder="Your data"/>                    <!--Формирование текстового поля-->
        <td> <input name="otch_pas" type="text"  placeholder="Your data"/>                     <!--Формирование текстового поля-->
        <td> <input name="data_rog" type="date" placeholder="Your data"/> 
        <td> <input name="sex" type="text" placeholder="Your data"/> 
        <td> <input name="ser_pasport" pattern="[0-9]{4}" type="text" placeholder="Your data"/> 
        <td> <input name="nom_pasport" pattern="[0-9]{6}"  type="text" placeholder="Your data"/>     
                 <!--Формирование текстового поля-->

<? 
        echo "<td>";
        $result1=mysql_query("Select * FROM Users");  //Запрос на вывод всех данных из таблицы Student
        echo "<select class='select_key' name='Users' >";       //Создание селекта
        while($myrow1=mysql_fetch_array($result1)){                                          
            echo "<option value = $myrow1[id_us]> $myrow1[login]</option>"; //Вывод данных
        };
        echo "</select></td>"; 
?> 
 <td> <input type="submit" value="Add" name="qwer" class="button"/> <!-- Создание кнопки добавить -->
    </tr>
</table> 
 <?
if(isset($_POST['qwer'])){ #Проверка на нажатие кнопки 
//переменные

 $fampas=$_POST['fam_pas'];
 $namepas=$_POST['name_pas'];
 $otchpas=$_POST['otch_pas'];
 $datarog=$_POST['data_rog'];
 $sex=$_POST['sex'];
 $serpasport=$_POST['ser_pasport'];
 $nompasport=$_POST['nom_pasport'];
 $users=$_POST['Users'];

//запрос на добавление данных в таблицу Student
 $result = mysql_query("INSERT INTO passegers (id_pas,fam_pas,name_pas,otch_pas,data_rog,sex,ser_pasport,nom_pasport,id_us) VALUES ('','$fampas','$namepas','$otchpas','$datarog','$sex','$serpasport','$nompasport','$users')");
 if ($result == true){  #Проверка на добавление
    echo"<script> window.location = 'aero.php' </script>"; #Перезапуск страницы
}else{
    echo "<script> alert (' Not all data entered ')</script>"; #Вывод алерта о неполном вводе данных
}
}
 ?>
  </form> <!-- Закрытие формы (кнопки) -->
</div>
</div>

	<div id="pilot" class="tabcontent">
      <h3>Таблица "Пилоты"</h3>
      <p>Таблица, в которую заносятся данные о пилотах</p>
      <form method="POST">
    <input type="submit" name="del5" value="Delete" class="button">  <!-- Создание кнопки удаления -->
    <input type="submit" name="save5" value="Save" class="button"> 
	<?
        include ('bd.php');

        $r=mysql_query("select * from pilot");
        $myrow=mysql_fetch_array($r);
        echo "<br>";
        echo "<table border='1'  cellspacing='0' cellpadding='4' class='tab'>";
        echo "<tr>";
        echo "<th align='center'>ID Пилота</th>";
        echo "<th align='center'>Фамилия</th>";
		echo "<th align='center'>Имя</th>";
		echo "<th align='center'>Отчество</th>";
        echo "<th align='center'>Дата рождения</th>";
        echo "<th align='center'>Модель самолета</th>";
        echo "<th></th>";
        echo "</tr>";

        do {
            $id_pilot=$myrow['id_pilot'];
            $fam_pilot=$myrow['fam_pilot'];
            $name_pilot=$myrow['name_pilot'];
            $otch_pilot=$myrow['otch_pilot'];
            $data_rog=$myrow['data_rog'];
			$id_samolet=$myrow['id_samolet'];

            echo "<tr>";
            echo "<td style='width:70px;' align='center'><input type='text' name='id_pilot[$id_pilot]' value='$id_pilot'></td>";
            echo "<td style='width:200px;' align='center'><input type='text' name='fam_pilot[$id_pilot]' value='$fam_pilot'></td>";
            echo "<td style='width:200px;' align='center'><input type='text' name='name_pilot[$id_pilot]' value='$name_pilot'></td>";
            echo "<td style='width:200px;' align='center'><input type='text' name='otch_pilot[$id_pilot]' value='$otch_pilot'></td>";
            echo "<td style='width:200px;' align='center'><input type='text' name='data_rog[$id_pilot]' value='$data_rog'></td>";
            echo "<td>";
            $result1=mysql_query("Select * FROM samolets");  //Запрос на вывод всех данных из таблицы Student
            echo "<select class='select_key' name='Samolets[$id_pilot]' >";       //Создание селекта
            do {                                          
                echo "<option ";                          //Создание пункта
                if ($myrow[id_samolet] == $id_samolet){          //ЕСЛИ ID_Test = выбранному тесту, то он будет выбранный
                    echo "selected ";                     //Выбрать элемент
                } 
                echo "value=$myrow[id_samolet]>$myrow[tip_samolet]</option>"; //Вывод данных
            }
            while($myrow=mysql_fetch_array($result1));
            echo "</select></td>"; 
            echo "<td align='center'><input style='width:70px;' name='id[$id_pilot]' type='checkbox' value='$id_pilot'></td>";
            echo "</tr>";
        }

        while ($myrow=mysql_fetch_array($r));

        if(isset($_POST['save5'])){ #Проверка на нажатие кнопки
            foreach($_POST['id_pilot'] as $key => $value){
                $sql="update pilot set id_pilot='".$value."' WHERE id_pilot=".$key; #Изменение id-st из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['fam_pilot'] as $key1 => $value1){
                $sql="update pilot set fam_pilot='".$value1."' WHERE id_pilot=".$key1; #Изменение FamSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['name_pilot'] as $key2 => $value2){
                $sql="update pilot set name_pilot='".$value2."' WHERE id_pilot=".$key2; #Изменение NameSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
             foreach($_POST['otch_pilot'] as $key3 => $value3){
                $sql="update pilot set otch_pilot='".$value3."' WHERE id_pilot=".$key3; #Изменение Otch из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['data_rog'] as $key4 => $value4){
                $sql="update pilot set data_rog='".$value4."' WHERE id_pilot=".$key4; #Изменение LoginSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['Samolets'] as $key5 => $value5){
                $sql="update pilot set id_samolet='".$value5."' WHERE id_pilot=".$key5; #Изменение id_gr из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        //Удаление
        if(isset($_POST['del5'])){  #Проверка на нажатие кнопки
            foreach($_POST['id'] as $key7 => $value7){
                $sql="Delete FROM pilot WHERE id_pilot=".$value7; //В ином случа сразу удалить студента
                mysql_query($sql); #Выполнение запроса
          }
              echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        ?>
        
        </form>
        
        <form method="POST" action="">
            <tr align="center">
                <td>Autho_inc</td> 
                <td> <input name="fam_pilot" type="text" placeholder="Your data"/>                     <!--Формирование текстового поля-->
                <td> <input name="name_pilot" type="text" placeholder="Your data"/>                    <!--Формирование текстового поля-->
                <td> <input name="otch_pilot" type="text"  placeholder="Your data"/>                     <!--Формирование текстового поля-->
                <td> <input name="data_rog" type="date" placeholder="Your data"/> 

        <? 
                echo "<td>";
                $result1=mysql_query("Select * FROM samolets");  //Запрос на вывод всех данных из таблицы Student
                echo "<select class='select_key' name='Samolets' >";       //Создание селекта
                while($myrow1=mysql_fetch_array($result1)){                                          
                    echo "<option value = $myrow1[id_samolet]> $myrow1[tip_samolet]</option>"; //Вывод данных
                };
                echo "</select></td>"; 
        ?> 
         <td> <input type="submit" value="Add" name="qwet" class="button"/> <!-- Создание кнопки добавить -->
            </tr>
        </table> 
         <?
        if(isset($_POST['qwet'])){ #Проверка на нажатие кнопки 
        //переменные
        
         $fampilot=$_POST['fam_pilot'];
         $namepilot=$_POST['name_pilot'];
         $otchpilot=$_POST['otch_pilot'];
         $datarog=$_POST['data_rog'];
         $samolets=$_POST['Samolets'];
        
        //запрос на добавление данных в таблицу Student
         $result = mysql_query("INSERT INTO pilot (id_pilot,fam_pilot,name_pilot,otch_pilot,data_rog,id_samolet) VALUES ('','$fampilot','$namepilot','$otchpilot','$datarog','$samolets ')");
         if ($result == true){  #Проверка на добавление
            echo"<script> window.location = 'aero.php' </script>"; #Перезапуск страницы
        }else{
            echo "<script> alert (' Not all data entered ')</script>"; #Вывод алерта о неполном вводе данных
        }
        }
         ?>
          </form> <!-- Закрытие формы (кнопки) -->
        </div>
        </div>

	<div id="reises" class="tabcontent">
      <h3>Таблица "Рейсы"</h3>
      <p>Таблица, в которую заносятся данные о рейсах</p>
      <form method="POST">
      <input type="submit" name="del6" value="Delete" class="button">  <!-- Создание кнопки удаления -->
      <input type="submit" name="save6" value="Save" class="button"> 
	<?
        include ('bd.php');

        $r=mysql_query("select * from reises");
        $myrow=mysql_fetch_array($r);
        echo "<br>";
        echo "<table border='1'  cellspacing='0' cellpadding='4' class='tab'>";
        echo "<tr>";
        echo "<th align='center'>ID Рейса</th>";
        echo "<th align='center'>Цена</th>";
        echo "<th align='center'>Время вылета</th>";
		echo "<th align='center'>Время прибытия</th>";
		echo "<th align='center'>Время в пути</th>";
        echo "<th align='center'>Дата вылета</th>";
		echo "<th align='center'>День недели</th>";
		echo "<th align='center'>Маршрут</th>";
        echo "<th style='width:130px;' align='center'>Самолет</th>";
        echo "<th align='center'></th>";
        echo "</tr>";

        do {
            $id_reis=$myrow['id_reis'];
            $cena = $myrow['cena'];
            $vil_time=$myrow['vil_time'];
            $prib_time=$myrow['prib_time'];
            $put_time=$myrow['put_time'];
            $data_vil=$myrow['data_vil'];
			$den_nedel=$myrow['den_nedel'];
			$id_marsh=$myrow['id_marsh'];
			$id_samolet=$myrow['id_samolet'];

            echo "<tr>";
            echo "<td style='width:50px;' align='center'><input type='text' name='id_reis[$id_reis]' value='$id_reis'></td>";
            echo "<td style='width:150px;' align='center'><input type='text' name='cena[$id_reis]' value='$cena'></td>";
            echo "<td style='width:150px;' align='center'><input type='text' name='vil_time[$id_reis]' value='$vil_time'></td>";
            echo "<td style='width:150px;' align='center'><input type='text' name='prib_time[$id_reis]' value='$prib_time'></td>";
            echo "<td style='width:150px;' align='center'><input type='text' name='put_time[$id_reis]' value='$put_time'></td>";
            echo "<td style='width:150px;' align='center'><input type='date' name='data_vil[$id_reis]' value='$data_vil'></td>";
            echo "<td style='width:150px;' align='center'><input type='text' name='den_nedel[$id_reis]' value='$den_nedel'></td>";
            
            echo "<td>";
            $result=mysql_query("Select * FROM marshrut");  //Запрос на вывод всех данных из таблицы Student
            echo "<select class='select_key' name='Marshruts[$id_reis]'>";       //Создание селекта
            do {                                          
                echo "<option ";                          //Создание пункта
                if ($myrow[id_marsh] == $id_marsh){          //ЕСЛИ ID_Test = выбранному тесту, то он будет выбранный
                    echo "selected ";                     //Выбрать элемент
                } 
                echo "value=$myrow[id_marsh]>$myrow[otpr_place] $myrow[naz_place]</option>"; //Вывод данных
            }
            while($myrow=mysql_fetch_array($result));
            echo "</select></td>"; 

			echo "<td>";
            $result1=mysql_query("Select * FROM samolets");  //Запрос на вывод всех данных из таблицы Student
            echo "<select class='select_key' name='Samolets[$id_reis]'>";       //Создание селекта
            do {                                          
                echo "<option ";                          //Создание пункта
                if ($myrow[id_samolet] == $id_samolet){          //ЕСЛИ ID_Test = выбранному тесту, то он будет выбранный
                    echo "selected ";                     //Выбрать элемент
                } 
                echo "value=$myrow[id_samolet]>$myrow[tip_samolet]</option>"; //Вывод данных
            }
            while($myrow=mysql_fetch_array($result1));
            echo "</select></td>"; 

            echo "<td align='center'><input style='width:70px;' name='id[$id_reis]' type='checkbox' value='$id_reis'></td>";
            echo "</tr>";
        }

        while ($myrow=mysql_fetch_array($r));

        if(isset($_POST['save6'])){ #Проверка на нажатие кнопки
            foreach($_POST['id_reis'] as $key => $value){
                $sql="update reises set id_reis='".$value."' WHERE id_reis=".$key; #Изменение id-st из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['cena'] as $key => $value){
                $sql="update reises set cena='".$value."' WHERE id_reis=".$key; #Изменение id-st из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['vil_time'] as $key1 => $value1){
                $sql="update reises set vil_time='".$value1."' WHERE id_reis=".$key1; #Изменение FamSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['prib_time'] as $key2 => $value2){
                $sql="update reises set prib_time='".$value2."' WHERE id_reis=".$key2; #Изменение NameSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
             foreach($_POST['put_time'] as $key3 => $value3){
                $sql="update reises set put_time='".$value3."' WHERE id_reis=".$key3; #Изменение Otch из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['data_vil'] as $key4 => $value4){
                $sql="update reises set data_vil='".$value4."' WHERE id_reis=".$key4; #Изменение LoginSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['den_nedel'] as $key5 => $value5){
                $sql="update reises set den_nedel='".$value5."' WHERE id_reis=".$key5; #Изменение LoginSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['Marshruts'] as $key6=> $value6){
                $sql="update reises set id_marsh='".$value6."' WHERE id_reis=".$key6; #Изменение id_gr из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['Samolets'] as $key7=> $value7){
                $sql="update reises set id_samolet='".$value7."' WHERE id_reis=".$key7; #Изменение id_gr из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        //Удаление
        if(isset($_POST['del6'])){  #Проверка на нажатие кнопки
            foreach($_POST['id'] as $key8 => $value8){
                $result = mysql_query("SELECT * FROM tickets WHERE id_reis = ".$value8);
                if ($result){
                    do{
                      mysql_query("DELETE FROM tickets WHERE id_reis=".$myrow['id_reis']);
                    } while($myrow = mysql_fetch_array($result));
                    mysql_query("DELETE FROM reises where id_reis=".$value8);
                };
          }
              echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        ?>
        
        </form>
        
        <form method="POST" action="">
            <tr align="center">
                <td>Autho_inc</td> 
                <td> <input name="cena" type="text" placeholder="Your data"/>  
                <td> <input name="vil_time" type="text" placeholder="Your data"/>                     <!--Формирование текстового поля-->
                <td> <input name="prib_time" type="text" placeholder="Your data"/>                    <!--Формирование текстового поля-->
                <td> <input name="put_time" type="text"  placeholder="Your data"/>                     <!--Формирование текстового поля-->
                <td> <input name="data_vil" type="date" placeholder="Your data"/> 
                <td> <input name="den_nedel" type="text"  placeholder="Your data"/> 

        <? 
                echo "<td>";
                $result=mysql_query("Select * FROM marshrut");  //Запрос на вывод всех данных из таблицы Student
                echo "<select class='select_key' name='Marshruts' >";       //Создание селекта
                while($myrow=mysql_fetch_array($result)){                                          
                    echo "<option value = $myrow[id_marsh]> $myrow[otpr_place]  $myrow[naz_place]</option>"; //Вывод данных
                };
                echo "</select></td>"; 

                echo "<td>";
                $result1=mysql_query("Select * FROM samolets");  //Запрос на вывод всех данных из таблицы Student
                echo "<select class='select_key' name='Samolets' >";       //Создание селекта
                while($myrow1=mysql_fetch_array($result1)){                                          
                    echo "<option value = $myrow1[id_samolet]> $myrow1[tip_samolet]</option>"; //Вывод данных
                };
                echo "</select></td>"; 
        ?> 
         <td> <input type="submit" value="Add" name="qweu" class="button"/> <!-- Создание кнопки добавить -->
            </tr>
        </table> 
         <?
        if(isset($_POST['qweu'])){ #Проверка на нажатие кнопки 
        //переменные
         $cena1=$_POST['cena'];
         $viltime=$_POST['vil_time'];
         $pribtime=$_POST['prib_time'];
         $puttime=$_POST['put_time'];
         $datavil=$_POST['data_vil'];
         $dennedel=$_POST['den_nedel'];
         $marshruts=$_POST['Marshruts'];
         $samolets=$_POST['Samolets'];
        
        //запрос на добавление данных в таблицу Student
         $result = mysql_query("INSERT INTO reises (id_reis,cena,vil_time,prib_time,put_time,data_vil,den_nedel,id_marsh,id_samolet) VALUES ('','$cena1','$viltime','$pribtime','$puttime','$datavil','$dennedel','$marshruts','$samolets')");
         if ($result == true){  #Проверка на добавление
            echo"<script> window.location = 'aero.php' </script>"; #Перезапуск страницы
        }else{
            echo "<script> alert (' Not all data entered ')</script>"; #Вывод алерта о неполном вводе данных
        }
        }
         ?>
          </form> <!-- Закрытие формы (кнопки) -->
        </div>
        </div>


	<div id="samolets" class="tabcontent">
      <h3>Таблица "Самолеты"</h3>
      <p>Таблица, в которую заносятся данные о самолетах</p>
      <form method="POST">
      <input type="submit" name="del7" value="Delete" class="button">  <!-- Создание кнопки удаления -->
      <input type="submit" name="save7" value="Save" class="button"> 

	<?
        include ('bd.php');

        $r=mysql_query("select * from samolets");
        $myrow=mysql_fetch_array($r);
        echo "<br>";
        echo "<table border='1'  cellspacing='0' cellpadding='4' class='tab'>";
		echo "<tr>";
		echo "<th style='width:50px' align='center'>ID Самолета</th>";
        echo "<th style ='width:170px' align='center'>Тип самолета</th>";
        echo "<th style ='width:170px' align='center'>Вместимость</th>";
        echo "<th style='width:70px;' align='center'></th>";
        echo "</tr>";

        do {
            $id_samolet=$myrow['id_samolet'];
            $tip_samolet=$myrow['tip_samolet'];
            $vmestimost=$myrow['vmestimost'];

            echo "<tr>";
			echo "<td align='center'><input type='text' name='id_samolet[$id_samolet]' value='$id_samolet'></td>";
            echo "<td align='center'><input type='text' name='tip_samolet[$id_samolet]' value='$tip_samolet'></td>";
            echo "<td align='center'><input type='text' name='vmestimost[$id_samolet]' value='$vmestimost'></td>";
            echo "<td align='center'><input name='id[$id_samolet]' type='checkbox' value='$id_samolet'></td>";
            echo "</tr>";
        }

        while ($myrow=mysql_fetch_array($r));

        if(isset($_POST['save7'])){ #Проверка на нажатие кнопки
            foreach($_POST['id_samolet'] as $key => $value){
                $sql="update samolets set id_samolet='".$value."' WHERE id_samolet=".$key; #Изменение id-st из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['tip_samolet'] as $key1 => $value1){
                $sql="update samolets set tip_samolet='".$value1."' WHERE id_samolet=".$key1; #Изменение FamSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['vmestimost'] as $key2 => $value2){
                $sql="update samolets set vmestimost='".$value2."' WHERE id_samolet=".$key2; #Изменение NameSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            
            echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        //Удаление
        if(isset($_POST['del7'])){  #Проверка на нажатие кнопки
            foreach($_POST['id'] as $key3 => $value3){
                $result = mysql_query("SELECT * FROM reises WHERE id_samolet=".$value3);
                        do{
                            mysql_query("DELETE FROM tickets WHERE id_reis = ".$myrow['id_reis']);
                    } while($myrow = mysql_fetch_array($result));
                    mysql_query("DELETE FROM reises where id_samolet = ".$value3);
                    mysql_query("DELETE FROM pilot where id_samolet = ".$value3);
                    mysql_query("DELETE FROM samolets where id_samolet = ".$value3);
          }
              echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        ?>
        
        </form>
        
        <form method="POST" action="">
            <tr align="center">
                <td>Autho_inc</td> 
                <td> <input name="tip_samolet" type="text" placeholder="Your data"/>                     <!--Формирование текстового поля-->
                <td> <input name="vmestimost" type="text" placeholder="Your data"/>                    <!--Формирование текстового поля-->

         <td> <input type="submit" value="Add" name="qwei" class="button"/> <!-- Создание кнопки добавить -->
            </tr>
        </table> 
         <?
        if(isset($_POST['qwei'])){ #Проверка на нажатие кнопки 
        //переменные
         $tipsamolet=$_POST['tip_samolet'];
         $vmestimostt=$_POST['vmestimost'];
         
        
        //запрос на добавление данных в таблицу Student
         $result = mysql_query("INSERT INTO samolets (id_samolet,tip_samolet,vmestimost) VALUES ('','$tipsamolet','$vmestimostt')");
         if ($result == true){  #Проверка на добавление
            echo"<script> window.location = 'aero.php' </script>"; #Перезапуск страницы
        }else{
            echo "<script> alert (' Not all data entered ')</script>"; #Вывод алерта о неполном вводе данных
        }
        }
         ?>
          </form> <!-- Закрытие формы (кнопки) -->
        </div>
        </div>


?>
	</div>

	<div id="tickets" class="tabcontent">
      <h3>Таблица "Билеты"</h3>
      <p>Таблица, в которую заносятся данные о билетах</p>
      <form method="POST">
      <input type="submit" name="del8" value="Delete" class="button">  <!-- Создание кнопки удаления -->
      <input type="submit" name="save8" value="Save" class="button">
	<?
        include ('bd.php');

        $r=mysql_query("select * from tickets");
        $myrow=mysql_fetch_array($r);
        echo "<br>";
        echo "<table border='1'  cellspacing='0' cellpadding='4' class='tab'>";
        echo "<tr>";
        echo "<th align='center'>ID Билета</th>";
        echo "<th align='center'>Стоимость</th>";
		echo "<th align='center'>Тип класса</th>";
		echo "<th align='center'>Отделение</th>";
        echo "<th align='center'>Место</th>";
		echo "<th align='center'>Дата продажи</th>";
		echo "<th align='center'>ФИО Пассажира</th>";
        echo "<th align='center'>Дата рейса</th>";
        echo "<th></th>";
        echo "</tr>";

        do {
            $id_ticket=$myrow['id_ticket'];
            $stoimost=$myrow['stoimost'];
            $tip_class=$myrow['tip_class'];
            $otdelenie=$myrow['otdelenie'];
			$mesto=$myrow['mesto'];
			$data_prodage=$myrow['data_prodage'];
			$id_pas=$myrow['id_pas'];
			$id_reis=$myrow['id_reis'];

            echo "<tr>";
            echo "<td style='width:50px;' align='center'><input type='text' name='id_ticket[$id_ticket]' value='$id_ticket'></td>";
            echo "<td style='width:120px;' align='center'><input type='text' name='stoimost[$id_ticket]' value='$stoimost'></td>";
            echo "<td style='width:120px;' align='center'><input type='text' name='tip_class[$id_ticket]' value='$tip_class'></td>";
            echo "<td style='width:120px;' align='center'><input type='text' name='otdelenie[$id_ticket]' value='$otdelenie'></td>";
			echo "<td style='width:70px;' align='center'><input type='text' name='mesto[$id_ticket]' value='$mesto'></td>";
			echo "<td style='width:120px;' align='center'><input type='date' name='data_prodage[$id_ticket]' value='$data_prodage'></td>";
            echo "<td>";
            $result=mysql_query("Select * FROM passegers");  //Запрос на вывод всех данных из таблицы Student
            echo "<select class='select_key' name='Passegers[$id_ticket]'>";       //Создание селекта
            do {                                          
                echo "<option ";                          //Создание пункта
                if ($myrow[id_pas] == $id_pas){          //ЕСЛИ ID_Test = выбранному тесту, то он будет выбранный
                    echo "selected ";                     //Выбрать элемент
                } 
                echo "value=$myrow[id_pas]>$myrow[fam_pas] $myrow[name_pas] $myrow[otch_pas]</option>"; //Вывод данных
            }
            while($myrow=mysql_fetch_array($result));
            echo "</select></td>"; 

            echo "<td>";
            $result1=mysql_query("Select * FROM reises");  //Запрос на вывод всех данных из таблицы Student
            echo "<select class='select_key' name='Reises[$id_ticket]'>";       //Создание селекта
            do {                                          
                echo "<option ";                          //Создание пункта
                if ($myrow1[id_reis] == $id_reis){          //ЕСЛИ ID_Test = выбранному тесту, то он будет выбранный
                    echo "selected ";                     //Выбрать элемент
                } 
                echo "value=$myrow1[id_reis]>$myrow1[data_vil] $myrow1[den_nedel]</option>"; //Вывод данных
            }
            while($myrow1=mysql_fetch_array($result1));
            echo "</select></td>";
            echo "<td align='center' style='width:50px;'><input name='id[$id_ticket]' type='checkbox' value='$id_ticket'></td>";
            echo "</tr>";
        }

        while ($myrow=mysql_fetch_array($r));

        if(isset($_POST['save8'])){ #Проверка на нажатие кнопки
            foreach($_POST['id_ticket'] as $key => $value){
                $sql="update tickets set id_ticket='".$value."' WHERE id_ticket=".$key; #Изменение id-st из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['stoimost'] as $key1 => $value1){
                $sql="update tickets set stoimost='".$value1."' WHERE id_ticket=".$key1; #Изменение FamSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['tip_class'] as $key2 => $value2){
                $sql="update tickets set tip_class='".$value2."' WHERE id_ticket=".$key2; #Изменение NameSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
             foreach($_POST['otdelenie'] as $key3 => $value3){
                $sql="update tickets set otdelenie='".$value3."' WHERE id_ticket=".$key3; #Изменение Otch из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['mesto'] as $key4 => $value4){
                $sql="update tickets set mesto='".$value4."' WHERE id_ticket=".$key4; #Изменение LoginSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['data_prodage'] as $key5 => $value5){
                $sql="update tickets set data_prodage='".$value5."' WHERE id_ticket=".$key5; #Изменение LoginSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['Passegers'] as $key6=> $value6){
                $sql="update tickets set id_pas='".$value6."' WHERE id_ticket=".$key6; #Изменение id_gr из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['Reises'] as $key7=> $value7){
                $sql="update tickets set id_reis='".$value7."' WHERE id_ticket=".$key7; #Изменение id_gr из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        //Удаление
        if(isset($_POST['del8'])){  #Проверка на нажатие кнопки
            foreach($_POST['id'] as $key8 => $value8){
                $sql="DELETE FROM tickets WHERE id_ticket=".$value8; //В ином случа сразу удалить студента
                mysql_query($sql); #Выполнение запроса
          }
              echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        ?>
        
        </form>
        
        <form method="POST" action="">
            <tr align="center">
                <td>Autho_inc</td> 
                <td> <input name="stoimost" type="text" placeholder="Your data"/>                     <!--Формирование текстового поля-->
                <td> <select name ="tip_class" class="select_key">
                <option disabled selected hidden>Your data</option>
                <option>бизнес</option> 
                <option>эконом</option>  
                </select>                   <!--Формирование текстового поля-->
                <td> <select name ="otdelenie" class="select_key">
                <option disabled selected hidden>Your data</option>
                <option>носовое</option> 
                <option>центральное</option>  
                <option>хвостовое</option>  
                </select>                     <!--Формирование текстового поля-->
                <td> <input name="mesto" type="text" placeholder="Your data"/> 
                <td> <input name="data_prodage" type="date"  placeholder="Your data"/> 

        <? 
                echo "<td>";
                $result=mysql_query("Select * FROM passegers");  //Запрос на вывод всех данных из таблицы Student
                echo "<select class='select_key' name='Passegers' >";       //Создание селекта
                while($myrow=mysql_fetch_array($result)){                                          
                    echo "<option value = $myrow[id_pas]> $myrow[fam_pas] $myrow[name_pas] $myrow[otch_pas]</option>"; //Вывод данных
                };
                echo "</select></td>"; 

                echo "<td>";
                $result1=mysql_query("Select * FROM reises");  //Запрос на вывод всех данных из таблицы Student
                echo "<select class='select_key' name='Reises' >";       //Создание селекта
                while($myrow1=mysql_fetch_array($result1)){                                          
                    echo "<option value = $myrow1[id_reis]>$myrow1[data_vil] $myrow1[den_nedel]</option>"; //Вывод данных
                };
                echo "</select></td>"; 
        ?> 
         <td> <input type="submit" value="Add" name="qwep" class="button"/> <!-- Создание кнопки добавить -->
            </tr>
        </table> 
         <?
        if(isset($_POST['qwep'])){ #Проверка на нажатие кнопки 
        //переменные
         $stoimost1=$_POST['stoimost'];
         $tipclass=$_POST['tip_class'];
         $otdelenie1=$_POST['otdelenie'];
         $mesto1=$_POST['mesto'];
         $dataprodage=$_POST['data_prodage'];
         $passegers=$_POST['Passegers'];
         $reises=$_POST['Reises'];
        
        //запрос на добавление данных в таблицу Student
         $result = mysql_query("INSERT INTO tickets (id_ticket,stoimost,tip_class,otdelenie,mesto,data_prodage,id_pas,id_reis) VALUES ('','$stoimost1','$tipclass','$otdelenie1','$mesto1','$dataprodage','$passegers','$reises')");
         if ($result == true){  #Проверка на добавление
            echo"<script> window.location = 'aero.php' </script>"; #Перезапуск страницы
        }else{
            echo "<script> alert (' Not all data entered ')</script>"; #Вывод алерта о неполном вводе данных
        }
        }
         ?>
          </form> <!-- Закрытие формы (кнопки) -->
        </div>
        </div>


?>
	</div>

	<div id="Users" class="tabcontent">
      <h3>Таблица "Пользователи"</h3>
      <p>Таблица, в которую заносятся данные о пользователях</p>
      <form method="POST">
      <input type="submit" name="del9" value="Delete" class="button">  <!-- Создание кнопки удаления -->
      <input type="submit" name="save9" value="Save" class="button">
	<?
        include ('bd.php');

        $r=mysql_query("select * from Users");
        $myrow=mysql_fetch_array($r);
        echo "<br>";
        echo "<table border='1' width='600px' cellspacing='0' cellpadding='4' class='tab'>";
        echo "<tr>";
        echo "<th style='width:50px;' align='center'>ID Пользователя</th>";
        echo "<th style='width:130px;' align='center'>Логин</th>";
		echo "<th style='width:130px;' align='center'>Пароль</th>";
        echo "<th style='width:130px;' align='center'>Уровень доступа</th>";
        echo "<th style='width:60px;' align='center'></th>";
        echo "</tr>";

        do {
            $id_us=$myrow['id_us'];
            $login=$myrow['login'];
            $pass=$myrow['pass'];
            $id_lvl=$myrow['id_lvl'];

            echo "<tr>";
            echo "<td align='center'><input type='text' name='id_us[$id_us]' value='$id_us'></td>";
            echo "<td align='center'><input type='text' name='login[$id_us]' value='$login'></td>";
            echo "<td align='center'><input type='text' name='pass[$id_us]' value='$pass'></td>";
            echo "<td>";
            $result=mysql_query("Select * FROM lvl_pass");  //Запрос на вывод всех данных из таблицы Student
            echo "<select class='select_key' name='Dostup[$id_us]'>";       //Создание селекта
            do {                                          
                echo "<option ";                          //Создание пункта
                if ($myrow[id_lvl] == $id_lvl){          //ЕСЛИ ID_Test = выбранному тесту, то он будет выбранный
                    echo "selected ";                     //Выбрать элемент
                } 
                echo "value=$myrow[id_lvl]>$myrow[naimen_lvl]</option>"; //Вывод данных
            }
            while($myrow=mysql_fetch_array($result));
            echo "</select></td>"; 
            echo "<td align='center'><input name='id[$id_us]' type='checkbox' value='$id_us'></td>";
            echo "</tr>";
        }

        while ($myrow=mysql_fetch_array($r));

        if(isset($_POST['save9'])){ #Проверка на нажатие кнопки
            foreach($_POST['id_us'] as $key => $value){
                $sql="update users set id_us='".$value."' WHERE id_us=".$key; #Изменение id-st из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['login'] as $key1 => $value1){
                $sql="update users set login='".$value1."' WHERE id_us=".$key1; #Изменение FamSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['pass'] as $key2 => $value2){
                $sql="update users set pass='".$value2."' WHERE id_us=".$key2; #Изменение NameSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
            foreach($_POST['id_lvl'] as $key3 => $value3){
                $sql="update users set id_lvl='".$value3."' WHERE id_us=".$key3; #Изменение NameSt из таблицы Student
                mysql_query($sql); #Выполнение запроса
            }
              
            echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        //Удаление
        if(isset($_POST['del9'])){  #Проверка на нажатие кнопки
            foreach($_POST['id'] as $key4 => $value4){
                $result = mysql_query("SELECT * FROM passegers WHERE id_us=".$value4);
                if ($result){
                    do{
                            mysql_query("DELETE FROM tickets WHERE id_pas = ".$myrow['id_pas']);
                            mysql_query("DELETE FROM bagage WHERE id_pas = ".$myrow['id_pas']);
                    } while($myrow = mysql_fetch_array($result));
                    mysql_query("DELETE FROM passegers where id_us = ".$value4);
                    mysql_query("DELETE FROM Users where id_us = ".$value4);
                };
          }
              echo"<script>window.location = 'aero.php' </script>"; #Перезапуск страницы
        };
        ?>
        
        </form>
        
        <form method="POST" action="">
            <tr align="center">
                <td>Autho_inc</td> 
                <td> <input name="login" type="text" placeholder="Your data"/>                     <!--Формирование текстового поля-->
                <td> <input name="pass" type="text" placeholder="Your data"/> 
           <?                      
                echo "<td>";
                $result=mysql_query("Select * FROM lvl_pass");  //Запрос на вывод всех данных из таблицы Student
                echo "<select class='select_key' name='Dostup' >";       //Создание селекта
                while($myrow=mysql_fetch_array($result)){                                          
                    echo "<option value = $myrow[id_lvl]>$myrow[naimen_lvl]</option>"; //Вывод данных
                };
                echo "</select></td>";
            ?>
         <td> <input type="submit" value="Add" name="qwel" class="button"/> <!-- Создание кнопки добавить -->
            </tr>
        </table> 
         <?
        if(isset($_POST['qwel'])){ #Проверка на нажатие кнопки 
        //переменные
         $login1=$_POST['login'];
         $pass1=$_POST['pass'];
         $dostup=$_POST['Dostup'];
         
        
        //запрос на добавление данных в таблицу Student
         $result = mysql_query("INSERT INTO Users (id_us,login,pass,id_lvl) VALUES ('','$login1','$pass','$dostup')");
         if ($result == true){  #Проверка на добавление
            echo"<script> window.location = 'aero.php' </script>"; #Перезапуск страницы
        }else{
            echo "<script> alert (' Not all data entered ')</script>"; #Вывод алерта о неполном вводе данных
        }
        }
         ?>
          </form> <!-- Закрытие формы (кнопки) -->
        </div>
        </div>

        <div id="InfoReis" class="tabcontent">
            <form action="" method="POST">
        <?
        include ('bd.php');

        $result=mysql_query("SELECT reises.id_reis, reises.data_vil, reises.den_nedel, marshrut.otpr_place, marshrut.naz_place FROM reises, marshrut WHERE (marshrut.id_marsh = reises.id_marsh)");  //Запрос на вывод всех данных из таблицы Student
                echo "<select class='select_otch' name='Reises' >";
                echo "<option isabled selected hidden>Выберите маршрут</option>";       //Создание селекта
                while($myrow=mysql_fetch_array($result)){                                          
                    echo "<option value = $myrow[id_reis]>$myrow[data_vil] | $myrow[den_nedel] | $myrow[otpr_place] - $myrow[naz_place]</option>"; //Вывод данных
                };
                echo "</select></td>"; 
                echo "<input class='button' type='submit' value='Search' name='crte'></input>";
                echo "<input class='button' type='submit' value='Excel' name='exsl'></input>";
                if(isset($_POST['crte'])){
                   $result1 = mysql_query("SELECT  marshrut.otpr_place, marshrut.naz_place, marshrut.kilomtrge,reises.data_vil, reises.put_time, samolets.tip_samolet, samolets.vmestimost 
                   FROM marshrut, reises, samolets 
                   WHERE (marshrut.id_marsh = reises.id_marsh) and (reises.id_samolet = samolets.id_samolet) and (reises.id_reis = ".$_POST[Reises].")");
                   $myrow1= mysql_fetch_array($result1);
                   $myrow2 = mysql_fetch_array(mysql_query("SELECT  COUNT(tickets.id_ticket) FROM tickets, reises WHERE (tickets.id_reis = reises.id_reis) and (reises.id_reis= ".$_POST[Reises].")"));
                   $myrow3 = mysql_fetch_array(mysql_query("SELECT  SUM(bagage.ves_bag) FROM bagage, reises, tickets, passegers WHERE (bagage.id_pas = passegers.id_pas) and (tickets.id_pas = passegers.id_pas) and (tickets.id_reis = reises.id_reis) and (reises.id_reis= ".$_POST[Reises].")"));
                   echo "<table class='tab'>";
                    echo "<tr>";
                    echo "<th colspan='9' style='text-align:center;'>Показатели рейса а/к Аэрофлот по этапам полета</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th colspan='2' style='padding:5px 7px 5px 7px;'>Этапы полета</th>";
                    echo "<th rowspan='2' style='padding:5px 7px 5px 7px;'>Расстояние <br>этапа(км)</th>";
                    echo "<th rowspan='2' style='padding:5px 7px 5px 7px;'>Дата <br>вылета</th>";
                    echo "<th rowspan='2' style='padding:5px 7px 5px 7px;'>Время <br>полета (час)</th>";
                    echo "<th rowspan='2' style='padding:5px 7px 5px 7px;'>Тип самолета</th>";
                    echo "<th rowspan='2' style='padding:5px 7px 5px 7px;'>Предельное <br>кол-во кресел</th>";
                    echo "<th colspan='2' style='padding:5px 7px 5px 7px;'>Перевозки на этапе полета</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Город вылета</th>";
                    echo "<th>Город посадки</th>";
                    echo "<th>Пассажиры (чел.)</th>";
                    echo "<th>Вес багажа (кг)</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td style='padding:5px 7px 5px 7px;' align='center'>$myrow1[otpr_place]</td>";
                    echo "<td style='padding:5px 7px 5px 7px;' align='center'>$myrow1[naz_place]</td>";
                    echo "<td style='padding:5px 7px 5px 7px;' align='center'>$myrow1[kilomtrge]</td>";
                    echo "<td style='padding:5px 7px 5px 7px;' align='center'>$myrow1[data_vil]</td>";
                    echo "<td style='padding:5px 7px 5px 7px;' align='center'>$myrow1[put_time]</td>";
                    echo "<td style='padding:5px 7px 5px 7px;' align='center'>$myrow1[tip_samolet]</td>";
                    echo "<td style='padding:5px 7px 5px 7px;' align='center'>$myrow1[vmestimost]</td>";
                    echo "<td style='padding:5px 7px 5px 7px;' align='center'>$myrow2[0]</td>";
                    echo "<td style='padding:5px 7px 5px 7px;' align='center'>$myrow3[0]</td>";
                    echo "</tr>";
                    echo "</table>";
                   
            };
      
           
        ?>

            </form>
        </div>

<script>
    function tableAdmin(evt, tableName) {
        /*Объявим все переменные*/
        var i, tabcontent, tablinks;
        /*Получим все элементы с классом tabcontent и спрячем их*/
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        /*Получим все элементы с классом tablinks и удалим активный класс*/
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace("active", "");
        }
        /*Покажем текущую вкладку и добавим активный класс на кнопку, которая откроет вкладку с ID по названию таблицы*/
        document.getElementById(tableName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    document.getElementById("defaultOpen").click();
    </script>
</body>
</html>