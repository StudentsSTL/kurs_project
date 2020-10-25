<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    session_start();
    ?>
    <html>
    <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <title>Авторизация</title>
    </head>
    <body>
    <b>@Papkov_Ilya</b>
    <form action="testreg.php" method="post">
    <h2>Authorization</h2>
    <input name="login" type="text" size="15" maxlength="15" placeholder="Login">
    <input name="password" type="password" size="15" maxlength="15" placeholder="Password">
  
    <input type="submit" name="submit" value="Sign in"> <!--**** Кнопочка (type="submit") отправляет данные на страничку testreg.php ***** --> 

<br>
 <!--**** ссылка на регистрацию, ведь как-то же должны гости туда попадать ***** --> 
<a href="reg.php">Sign Up</a> 
    </form>
    <br>
    <?php
    // Проверяем, пусты ли переменные логина и id пользователя
    if (empty($_SESSION['login']) or empty($_SESSION['id']))
    {
    // Если пусты, то мы не выводим ссылку
    //echo "Вы вошли на сайт, как гость<br><a href='#'>Эта ссылка  доступна только зарегистрированным пользователям</a>";
    }
    else
    {

    // Если не пусты, то мы выводим ссылку
    //echo "<a  href='http://tvpavlovsk.sk6.ru/'>Эта ссылка доступна только  зарегистрированным пользователям</a>";
    }
    ?>
    </body>
    </html>