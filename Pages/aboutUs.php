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

        <div id="whitebg">
            <h1 id="Hh1"><?=$AUheader?></h1>
            <hr>
            <div id ="content">
                <p class='contenttext'><?=$AUcontent?>Deze website is medemogelijk gemaakt door de eerste jaars studenten van projectgroep INF1D, van de hogeschool NHL Stenden in Emmen en alle docenten die hierbij hebben meegeholpen.
                Wij, INF1D, willen iedereen die heeft meegeholpen graag bedanken voor het waarmaken van dit project.
                De opdrachtgevers van dit project zijn: Kirsten Lanting & Laura Redder.</p>           
            </div>

            
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            
                <?php 
                /* Footer */
                include_once '../Include/Footer.php';
                ?> 
            
    </body>

</html>