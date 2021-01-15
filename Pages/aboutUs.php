<!DOCTYPE HTML>
<html>
    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="stylesheet" href="../Css/Responsive.css">
        <?php
        if($_COOKIE['taal'] == 'english') {
            echo "<title>About Us</title>";
        }
        if($_COOKIE['taal'] == 'nederlands') {
            echo "<title>Over Ons</title>";
        }
        ?>
    </head>
    <body>
        <header> 
            <?php 
            /* Header */
            include_once '../Include/Header.php';
            ?>
        </header>

        <div class="AU" id="whitebg">
            <h1 id="Hh1"><?=$AUheader?></h1>
            <hr>
            <div id ="content">
                <p class='contenttext'><?=$AUcontent?></p>           
            </div>
        </div>
            
                <?php 
                /* Footer */
                include_once '../Include/Footer.php';
                ?> 
            
    </body>

</html>