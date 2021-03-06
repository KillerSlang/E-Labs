<!DOCTYPE HTML>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <link rel="shortcut icon" type="image/png" href="../Images/favicon.png"/>
    <?php
        if($_COOKIE['taal'] == 'english') {
            echo "<title>Settings</title>";
        }
        else{
            echo "<title>Instellingen</title>";
        }
    ?>
</head>
<body>
    <?php 
    /* Header en database handler*/
    include_once '../Include/Header.php';
    include_once '../Include/Dbh.inc.php';
    ?>
    <div id="Iachtergrond">
    <main>
        <div></div>
        <div id="Imain">            
            <h1 id=Ih1>Account <?=$Instellingen?></h1>
            <hr>
            <h2><?=$Naam?>:</h2>
            <?php 
            echo $_SESSION["Name"];
            
            /* studentnummer weergeven */
            if ($_SESSION['SorD'] == 'Student') {
                echo "<h2>".$StudentNummer."</h2>".$_SESSION["studentNummer"];
            }
            ?>
            <form action="taalverander.php" method="POST" enctype="multipart/form-data">
            <?php
            /* jaar weergave */

            if($_SESSION['SorD'] == "Student"){
                    echo "<h2>".$Jaar."</h2>";
                    if (empty($_SESSION['jaar'])) {
                        $_SESSION['jaar'] = '1';
                    }
                    if ($_SESSION['jaar'] == '1') {
                    echo "<select class='select' name='jaar'>
                        <option value='1' selected>".$Jaar1."</option>
                        <option value='2'>".$Jaar2."</option>
                        <option value='3'>".$Jaar3."</option>
                    </select>";
                    }
                    if ($_SESSION['jaar'] == '2') {
                        echo "<select class='select' name='jaar'>
                                <option value='1'>".$Jaar1."</option>
                                <option value='2' selected>".$Jaar2."</option>
                                <option value='3'>".$Jaar3."</option>
                            </select>";
                    }
                    if ($_SESSION['jaar'] == '3') {
                    echo "<select class='select' name='jaar'>
                            <option value='1'>".$Jaar1."</option>
                            <option value='2'>".$Jaar2."</option>
                            <option value='3' selected>".$Jaar3."</option>
                        </select>";
                    }
                }
                    /* taal knoppen en Opslaan knop*/
                    echo "<h2>".$Taal."</h2>";

                    if ($_COOKIE['taal'] == 'english') {
                        echo     "<input type='radio' name='taal' value='Nederlands'>
                                     <label>Nederlands</label>
                                 <input type='radio' name='taal' value='English' checked>
                                     <label>English</label><br>
                                 <input class='save' type='submit' name='Opslaan' value='Save'>";
                    } else {
                        echo    "<input type='radio' name='taal' value='Nederlands' checked>
                                    <label>Nederlands</label>
                                <input type='radio' name='taal' value='English'>
                                    <label>English</label><br>
                                <input class='save' type='submit' name='Opslaan' value='Opslaan'>";
                    }

                
            ?>
            </form>
            <form action="Instellingen.php" method="POST">
            <?php
            /* submit knoppen. Wachtwoord en Uitloggen */
            
                if ($_COOKIE['taal'] == 'nederlands') {
                    echo "
                    <div class='Iknoppen'>
                        <input class='bluebtn' type='submit' name='WWwijzig' value='Wachtwoord Wijzigen'>
                        <div class='empty'></div>
                        <input class='Iuitlog' type='submit' name='Uitloggen' value='Uitloggen'>
                    </div> ";
                }
                if ($_COOKIE['taal'] == 'english') {
                    echo "
                    <div class='Iknoppen'>
                        <input class='bluebtn' type='submit' name='WWwijzig' value='Change Password'>
                        <div class='empty'></div>
                        <input class='Iuitlog' type='submit' name='Uitloggen' value='Log Out'>
                    </div> ";
                }
            
            ?>
            </form>
            <?php

            /* opslaan */
            if(isset($_POST["Opslaan"])) {
                header("location:taalverander.php");
            }

            /* wachtwoord wijzigen */
            if(isset($_POST["WWwijzig"])) {
                header("location:wwvergeten.php");
            }
            
            /* Uitloggen met de knop */
            if(!empty($_POST["Uitloggen"])) {
                header("location:Logout.php");
                exit();
            }
            ?>
        </div>
    </main>
    </div>
    <?php 
    /* Footer */
    include_once '../Include/Footer.php';
    ?>    
</body>