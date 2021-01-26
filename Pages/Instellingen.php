<!DOCTYPE HTML>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    
</head>
<body>
    <?php 
    /* Header */
    include_once '../Include/Header.php';
    include_once '../Include/Dbh.inc.php';
    ?>
    <main>
<div id="Imain">
            <h1>Accountinstellingen</h1>
            <hr>
            <h2>Naam:</h2>
            <?php
            /* naam weergeven van student */
            echo $_SESSION["Name"];
            ?>
            <h2>Studenten nummer:</h2>
            <?php
            /* studentnummer weergeven */
            echo $_SESSION["studentID"];
            ?>
            <form action="Instellingen.php" method="POST">
                <h2>Jaar</h2>
                <select>
                    <option>Jaar 1</option>
                    <option>Jaar 2</option>
                    <option>Jaar 3</option>
                </select>
                <h2>Taal</h2>
                <input type="radio" name="taal" value="Nederlands" checked>
                <label>Nederlands</label>
                <input type="radio" name="taal" value="English">
                <label>English</label><br>
                <input type="submit" name="WWwijzig" value="Wachtwoord Wijzigen">
                <input type="submit" name="Uitloggen" value="Uitloggen">
            </form>
            <?php
            /* wachtwoord wijzigen */
            if(!empty($_POST["WWwijzig"])) {
                header("location:wwvergeten.php");
            }
            
            /* Uitloggen met de knop */
            if(!empty($_POST["Uitloggen"])) {
                session_unset();
                session_destroy();
                header("location:Inlog.php");
                exit();
            }

            /* taal selectie
            if(isset($_POST['taal'])) {
                if ("taal" = "Nederlands") {
                    $_SESSION['taal'] = "Nederlands";
                }
                if ("taal" = "English") {
                    $_SESSION['taal'] = "English";
                }
            }
            */
            ?>
        </div>
    </main>
    <?php 
    /* Footer */
    include_once '../Include/Footer.php';
    ?>    
</body>