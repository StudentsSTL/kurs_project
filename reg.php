<html>
    <head>
        <link rel="stylesheet" href="css/reg.css">
        <meta charset="utf-8">
        <title>Регистрация</title>
    </head>
<body>
   
    <form action="save_user.php" method="POST">
    <h2>Registration</h2>
        <input class="text" name="fam_pas" type="text" size="15" maxlength="15" placeholder="Surname">
        <input class="text" name="name_pas" type="text" size="15" maxlength="15" placeholder="Name">
        <input class="text" name="otch_pas" type="text" size="15" maxlength="15" placeholder="Middle name">
        <table style="position:relative; width: 17rem; margin-bottom:13px;">
            <tr>
                <td><input name="data_rog" type="date" id="myDate" size="15" maxlength="15" placeholder="Password">
                </td>
                <td>
                    <select name="sex" class="sex_sel">
                    <option disabled selected hidden>S</option> 
                    <option>М</option>
                    <option>Ж</option>
                    </select>
                </td>
            </tr>
        </table>
        <table style="position:relative;width: 17rem; margin-bottom:13px;">
            <tr>
                <td style="padding-left:6%;"><input class="ser_pas" name="ser_pasport" type="text" min="0001" max="9999" size="4" maxlength="4" placeholder="Series"></td>
                <td style="padding-left:4%;"><input class="nom_pas" name="nom_pasport" type="text" min="000001" max="999999"size="6" maxlength="6" placeholder="Number"></td>
            </tr>
        </table>
        <input class="text" name="login" type="text" size="15" maxlength="15" placeholder="Login">
        <input class="text" name="pass" type="password" size="15" maxlength="15" placeholder="Password">
        <input type="submit" name="submit" value="Sign Up">
        <a href="index.php">Go back</a> 
</form>
<script>
    document.getElementById('myDate').valueAsDate = new Date();
</script>
</body>
</html>