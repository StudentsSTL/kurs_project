<?
    session_start();
    include('bd.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bronirovanie.css">
    <title>Бронирование</title>
</head>
<body>
    <form method="POST">
    <?
    echo "<div class='bron_form'>";
    echo "<h2>Бронирование</h2>";
    echo "<table class='tab' border='1px'>";
    echo "<tr>";
    echo "<th colspan='4'>Информация о рейсе</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td rowspan='2'>".$_SESSION['data_vil']."<br>".$_SESSION['den_nedel'] ."</td>";
    echo "<td>". $_SESSION['vil_time'] ."</td>";
    echo "<td>". $_SESSION['prib_time'] ."</td>";
    echo "<td width='80px' rowspan='2'>".$_SESSION['put_time']."</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>".$_SESSION['otpr_place'] ."</td>";
    echo "<td>".$_SESSION['naz_place'] ."</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<th colspan='4'>Информация о Билете</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>".$_SESSION['cena'] ."</td>";
    echo "<td>";
    echo "<select name='class'>";
    echo "<option value='1'>Эконом</option>"; 
    echo "<option value='2'>Бизнес</option>";
    echo "</select></td>";
    echo "<td>";
    echo "<select name = 'otdelenie'>";
    echo "<option value='носовое'>Носовое</option>"; 
    echo "<option value='центральное'>Центральное</option>";
    echo "<option value='хвостовое'>Хвостовое</option>";
    echo "</select></td>";
    echo "<td><input name='mesto' type='text' placeholder='Желаемое место'></input></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<th colspan='4'>Информация о Пассажире</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>".$_SESSION['fam_pas'] ."</td>";
    echo "<td>".$_SESSION['name_pas'] ."</td>";
    echo "<td>".$_SESSION['otch_pas'] ."</td>";
    echo "<td><input class='bron_but' name='nahui' type='submit' value='Бронировать'/></td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    if(isset($_POST['nahui'])){
        $data = date("Y-m-d");
        $class = $_POST['class'];
        if ($class == 1){
            $nameclass = 'эконом';
            $stoimost = $_SESSION['cena'] * $class;
        }else{
            $nameclass = 'бизнес';
            $stoimost = $_SESSION['cena'] * $class;
        };
        $result = mysql_query("INSERT INTO tickets (id_ticket,stoimost, tip_class, otdelenie, mesto, data_prodage, id_pas, id_reis) VALUES ('','$stoimost','$nameclass','$_POST[otdelenie]','$_POST[mesto]','$data','$_SESSION[id_pas]','$_SESSION[id_reis]')");
        if($result){
            echo "<script>alert('Ваша заявка принята!')</script>";
            $subject = "Вы успешно забронировали билет";

            $to = "ilyapapkov.236@gmail.com";

            $message = "<h3>Здравствуйте, $_SESSION[fam_pas] $_SESSION[name_pas] $_SESSION[otch_pas]</h3><br><p>Вы успешно забронировали билет на рейс $_SESSION[otpr_place] - $_SESSION[naz_place] на дату 
            $_SESSION[data_vil] | $_SESSION[den_nedel]. Спасибо, что выбрали нашу авиакомпанию!<br>Просим вас приехать в офис.</p>";
            $headers = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: АэроФлот";
            mail($to, $subject, $message, $headers);

            
        };
    };

    ?>
    </form>
</body>
</html>