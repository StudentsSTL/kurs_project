<?
    session_start();
    include('bd.php');
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/main.css">
    <title>Главная страница</title>
    <style>
  .carousel-inner img {
    width: 100%;
    height: 100%;
  }
    </style>
    </head>
    <body>
    <a name="main"> <header></a>
        <img class="logo-img" src="css/images/png/logo.png">
        <ul>
			<li><a href="#main">Главная</a></li>
			<li><a href="#history">История</a></li>
			<li><a href="#works">О нас</a></li>
			<li><a href="#tel">Контакты</a></li>
        </ul>
        <?
            echo "<p class='user_info'>".$_SESSION['fam_pas']." ".$_SESSION['name_pas']."</p><br>" ;
            echo "<a href='exit.php' ><input class='user_button' type='button' value='Выход'></input></a>";
        ?>
        </header>
        <main>  
        
        <div class="bron">
            <form method="post">
                <input name ="inp1" id="from" type="text" placeholder="Откуда" onfocus="this.style.borderColor = '#ffb320';" onblur="this.style.borderColor = '#034a94';"></input>
                <button id="swapBut" class="smena" onClick="swap()">< ></button>
                <input name ="inp2" id="for" type=text" placeholder="Куда" onfocus="this.style.borderColor = '#ffb320';" onblur="this.style.borderColor = '#034a94';"></input>
                <input name ="inp3" type="date" id="myDate" onfocus="this.style.borderColor = '#ffb320';" onblur="this.style.borderColor = '#034a94';"></input>
                <button type="submit" name = "search" class="search" >Search</button>

             </form>

</div>
            <form method="POST">
            <?
                    if(isset($_POST['search'])){
                        $otk = $_POST['inp1'];
                        $kuda = $_POST['inp2'];
                        $kada = $_POST['inp3'];
                        $r=mysql_query("SELECT reises.id_reis, otpr_place, naz_place, data_vil, den_nedel, put_time, vil_time, prib_time, cena FROM `reises`, `marshrut` WHERE (reises.id_marsh = marshrut.id_marsh) and (marshrut.otpr_place like '$otk') and (marshrut.naz_place like '$kuda') and (reises.data_vil like '$kada')");
                        $myrow=mysql_fetch_array($r);
                        $_SESSION['id_reis'] = $myrow['id_reis'];
                        $_SESSION['otpr_place'] = $myrow['otpr_place'];
                        $_SESSION['naz_place'] = $myrow['naz_place'];
                        $_SESSION['data_vil'] = $myrow['data_vil'];
                        $_SESSION['den_nedel'] = $myrow['den_nedel'];
                        $_SESSION['put_time'] = $myrow['put_time'];
                        $_SESSION['vil_time'] = $myrow['vil_time'];
                        $_SESSION['prib_time'] = $myrow['prib_time'];
                        $_SESSION['cena'] = $myrow['cena'];
                        if ($myrow['otpr_place']){
                        echo "<table class='tab' border='1px' width='1000px'>";
                        echo "<tr style='border-top:2px solid #1aa6b7;'>";
                        echo "<th align='center'>Число<br>День недели</th>";
                        echo "<th>Время отправления<br>Город отправления</th>";
                        echo "<th>Остановки</th>";
                        echo "<th>Время прибытия<br>Город прибытия</th>";
                        echo "<th>Продолжительность<br>полета</th>";
                        echo "<th>Тип класса<br>Стоимость</th>";
                        echo "<th><input style='width:120px;' type='submit' class='refresh' value='Refresh'></input></th>";
                        echo "</tr>";
        
                        do{
                            echo "<tr>";
                            echo "<td style='border-bottom:1px solid #1aa6b7;' rowspan='2'>".$myrow['data_vil']."<br>".$myrow['den_nedel']."</td>";
                            echo "<td style='font-size:20px; padding-bottom:5px;'>".$myrow['vil_time']."</td>";
                            echo "<td style='padding-right:2px; padding-left:2px; border-bottom:1px solid #1aa6b7;' rowspan='2' align='center'><div class='d15'></div>без остановок</td>";
                            echo "<td style='font-size:20px; padding-bottom:5px;'>".$myrow['prib_time']."</td>";
                            echo "<td style='border-bottom:1px solid #1aa6b7; font-size:20px; padding-bottom:5px;' rowspan='2'>".$myrow['put_time']."</td>";
                            echo "<td style='font-size:15px; padding-bottom:5px;'>Эконом</td>";
                            echo "<td style='border-bottom:1px solid #1aa6b7;' rowspan='2' align='center'><a href='bronirovanie.php'><button type='submit' value='Забронировать'/>Забронировать</a></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td style='border-bottom:1px solid #1aa6b7; font-size:20px;font-weight:700; padding-top:5px; padding-top:5px; padding-bottom:15px;'>".$myrow['otpr_place']."</td>";
                            echo "<td style='border-bottom:1px solid #1aa6b7; font-size:20px;font-weight:700; padding-top:5px; padding-bottom:15px;'>".$myrow['naz_place']."</td>";
                            echo "<td style='border-bottom:1px solid #1aa6b7; font-size:15px; padding-top:5px; padding-top:5px; padding-bottom:15px;'>".$myrow['cena']."</td>";
                            echo "</tr>";
                        }
                        while($myrow=mysql_fetch_array($r));

                        echo "</table>";
                    }
                    else{
                        echo "<div class='error_info'>";
                        echo "<b class='info_error'>Рейс не найден! Проверьте корректность введенных данных.</b><br>";
                        echo "<button type='submit' class='refresh'>Refresh</button>";
                        echo "</div>";
                    }
                    exit;
                        };
                ?>
                </form>
                <div class="main_str">
                    <h2>Покоряем небеса вместе с вами с 1932 года</h2>
                    <p>Одна из крупнейших авиакомпаний в мире</p>
                </div>
                <div class="about_us">
                <a name="history"><h3>История</h3></a>
                <p class="p1">
                25 февраля 1932 года ВОГВФ при Совете Труда и Обороны преобразовано в Главное управление гражданского воздушного флота (ГУГВФ) при Совете Народных Комиссаров СССР.
                25 марта того же года ГУГВФ получило сокращённое наименование «Аэрофлот».
                Начиная с 1935 года и до начала 1990-х годов, за исключением чехословацких самолётов для местных авиалиний Aero-45/145, L-410 и польского самолёта для выполнения сельскохозяйственных работ M-15, «Аэрофлот» эксплуатировал
                воздушные лайнеры исключительно советского производства, в том числе выпущенные на заводах в государствах СЭВ (ГДР — Ил-14, ПНР — Ан-2, Ми-2, ЧССР — Ил-14) в рамках социалистической интеграции.
                </p>
                <p class="p2">
                Советские авиалинии прекратили своё существование с момента принятия Постановления Правительства РФ № 527 от 27 июля 1992 года «О мерах по организации международных воздушных сообщений Российской Федерации», на основании которого производственно-коммерческое объединение «Аэрофлот - советские авиалинии» с входящими в него 
                структурами было преобразовано в АООТ «Аэрофлот — российские международные авиалинии» с сохранением полномочий по действующим межправительственным соглашениям с зарубежными странами, иностранными авиакомпаниями, фирмами и организациями. Данное преобразование стало решением правовой несостыковки возникшей после распада СССР, 
                когда существовавшее производственно-коммерческое объединение, выполнявшее международные полёты, фактически отошло к России, но юридически представляло за рубежом несуществующее государство.
                </p>
                <p class="p3">
                Таким образом современный Аэрофлот унаследовал известную всему миру советскую торговую марку и регулярные валютные поступления от иностранных авиакомпаний за выполняемые ими полёты по транссибирским маршрутам — порядка 500 миллионов долларов в год.
                </p>
                </div>
</main>

</body>

<script>
        document.getElementById('myDate').valueAsDate = new Date();
        
       function swap() {
         var elem = document.getElementById("swapBut");

        if (elem.className == "smena") {
            var frm = document.getElementById('from').value;
                to = document.getElementById('for').value;

            document.getElementById('from').value = to;
            document.getElementById('for').value = frm;
}
};
    </script>


</html>