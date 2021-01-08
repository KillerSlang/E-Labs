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
            <h1 id=Ih1>Account <?=$Instellingen?></h1>
            <hr>
            <h2><?=$Naam?>:</h2>
            <?php 
            echo $_SESSION["Name"];
            
            /* studentnummer weergeven */
            if ($_SESSION['SorD'] == 'Student') {
                echo "<h2>".$StudentNummer."</h2>".$_SESSION["StudentID"];
            }
            ?>
            <form action="taalverander.php" method="POST" enctype="multipart/form-data">
            <?php
                if ($_COOKIE['taal'] == 'nederlands') {
                echo "<h2>Jaar</h2>
                <select class='select' name='jaar'>
                    <option value='1'>Jaar 1</option>
                    <option value='2'>Jaar 2</option>
                    <option value='3'>Jaar 3</option>
                </select>
                <h2>Taal</h2>
                <input type='radio' name='taal' value='Nederlands' checked>
                <label>Nederlands</label>
                <input type='radio' name='taal' value='English'>
                <label>English</label><br>
                <input class='save' type='submit' name='Opslaan' value='Opslaan'>";
                }
                /* onclick=window.location='http://localhost/github/E-Labs/Pages/taalverander.php'; */
                if ($_COOKIE['taal'] == 'english') {
                    echo "<h2>Year</h2>
                    <select class='select' name='jaar'>
                        <option value='1'>Year 1</option>
                        <option value='2'>Year 2</option>
                        <option value='3'>Year 3</option>
                    </select>
                    <h2>Language</h2>
                    <input type='radio' name='taal' value='Nederlands'>
                    <label>Nederlands</label>
                    <input type='radio' name='taal' value='English' checked>
                    <label>English</label><br>
                    <input class='save' type='submit' name='Opslaan' value='Save'>";
                }
                /*  onclick=window.location='https://elabs.serverict.nl/Pages/Instellingen.php'; */

            ?>
            </form>
            <form action="Instellingen.php" method="POST">
            <?php
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
    <?php 
    /* Footer */
    include_once '../Include/Footer.php';
    ?>    
</body>