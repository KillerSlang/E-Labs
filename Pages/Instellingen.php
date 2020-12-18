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
        <div></div>
        <div id="Imain">
            <?php
                if ($_SESSION['taal'] == 'nederlands') {
                echo "<h1 id=Ih1>Account instellingen</h1>";
                }
                if ($_SESSION['taal'] == 'engels') {
                    echo "<h1 id=Ih1>Account Settings</h1>";
                }
                echo "<hr>";

                if ($_SESSION['taal'] == 'nederlands') {
                echo "<h2>Naam:</h2>";
                }
                if ($_SESSION['taal'] == 'engels') {
                    echo "<h2>Name:</h2>";
                }
            /* naam weergeven van student/docent */
            echo $_SESSION["Name"];
            
            /* studentnummer weergeven */
            $_SESSION['SorD'] = 'Student';
            if ($_SESSION['SorD'] == 'Student') {
                if ($_SESSION['taal'] == 'nederlands') {
                    echo "<h2>Student Nummer</h2>";
                }
                if ($_SESSION['taal'] == 'engels') {
                    echo "<h2>Student Number</h2>";
                }
                echo $_SESSION["StudentID"];
            }
            ?>
            <form action="Instellingen.php" method="POST">
            <?php
                $_SESSION['taal'] = 'engels';
                if ($_SESSION['taal'] == 'nederlands') {
                echo "<h2>Jaar</h2>
                <select>
                    <option>Jaar 1</option>
                    <option>Jaar 2</option>
                    <option>Jaar 3</option>
                </select>
                <h2>Taal</h2>
                <input type=radio name=taal value=Nederlands checked>
                <label>Nederlands</label>
                <input type=radio name=taal value=English>
                <label>English</label><br>";
                }
                if ($_SESSION['taal'] == 'engels') {
                    echo "<h2>Year</h2>
                    <select>
                        <option>Year 1</option>
                        <option>Year 2</option>
                        <option>Year 3</option>
                    </select>
                    <h2>Language</h2>
                    <input type=radio name=taal value=Nederlands>
                    <label>Nederlands</label>
                    <input type=radio name=taal value=English checked>
                    <label>English</label><br>";
                }
            ?>
                <div id="Iknoppen">
                <input class="bluebtn" type="submit" name="WWwijzig" value="Wachtwoord Wijzigen">
                <div class="empty"></div>
                <input id="Iuitlog" type="submit" name="Uitloggen" value="Uitloggen">
                </div>
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
                header("location:Logout.php");
                exit();
            }

            /*taal selectie */
            if(isset($_POST['taal'])) {
                if ($_POST["taal"] == "Nederlands") {
                    $_SESSION['taal'] = "nederlands";
                }
                if ($_POST["taal"] = "English") {
                    $_SESSION['taal'] = "English";
                }
            }
            
            ?>
        </div>
    </main>
    <?php 
    /* Footer */
    include_once '../Include/Footer.php';
    ?>    
</body>
</html>