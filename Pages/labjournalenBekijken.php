<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/cda83c7af3.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="stylesheet" href="../Css/Responsive.css">
        <title>LabjournaalBekijken</title>
    </head>
    <body>
    <?php 
            /* Include header en database handler */
            include_once '../Include/Header.php';
            include_once '../Include/Dbh.inc.php';

            function get_options($select) // Functie om de selectknop voor BML en Chemie Onchange te veranderen.
            {
                $vakken = array('BML','Chemie');
                $options = '';
                foreach($vakken as $input)
                {
                    if($select == $input)
                    {
                        $options .= '<option value="'.$input.'" selected>'.$input.'</option>';
                    }
                    else
                    {
                        $options .= '<option value="'.$input.'" >'.$input.'</option>';
                    }
                }
                return $options;
            }
            if(isset($_POST["vak"])) //wanneer vak is opgehaald uit de post print deze uit als geselecteerd. 
            {
                $selected = $_POST["vak"];
                $_SESSION["select"] = $selected;
            }
            else // wanneer er geen post waarde is. Dan is BML het standaard vak.
            {
                if(isset($_SESSION["select"])) 
                {
                    $selected = $_SESSION["select"];
                }else {$selected = "BML";}
            }
        ?>
        <main id="Protocol">
        <div class="PageTitle">
                <h1>Te bekijken labjournalen</h1>
                <hr>
            </div>
            <div class="whitebg">
                <div class="content">
                    <a class="Lbutton" href='labjournalenBekijken.php?jaar=3'>Jaar 3</a>
                    <a class="Lbutton" href='labjournalenBekijken.php?jaar=2'>Jaar 2</a>
                    <a class="Lbutton" href='labjournalenBekijken.php?jaar=1'>Jaar 1</a>
                    <a class="Lbutton" href='labjournalenBekijken.php?jaar=0'>Alle jaren</a>
                    <!-- Formulier van de select button van BML en Chemie -->
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="selectform" method="post">
                        <select class="Lbutton" name="vak" onchange="this.form.submit();">                        
                            <?PHP
                                echo get_options($selected);
                            ?>
                        </select>
                    </form>
                    <a class="Lbutton" id="PbuttonLeft" href='labjournalen.php'>Bewerk labjournalen</a>
                    <br>
                    <?php
                        queryAanmaken('SELECT studentNummer
                                        FROM student
                                        WHERE studentID = '.$_SESSION["StudentID"]);// zoek het studentnummer op van de ingelogde student.
                        mysqli_stmt_bind_result($stmt,$studentNummer);
                        mysqli_stmt_store_result($stmt);
                        if(mysqli_stmt_num_rows($stmt) != 0)
                        {
                            while (mysqli_stmt_fetch($stmt)) 
                            {
                                $studentNummer = $studentNummer;
                            }
                        }
                        querysluiten(); 
                        queryaanmaken('SELECT uitvoerders,labjournaalID
                                    FROM labjournaal');// haal de uitvoerders array en labjournaalID op uit de database.
                        mysqli_stmt_bind_result($stmt,$uitvoerders,$labjournaalID);
                        mysqli_stmt_store_result($stmt);  
                        if(mysqli_stmt_num_rows($stmt) != 0)
                        {            
                            $labjournalenArray = array(); // maak een nieuwe array aan.             
                            while (mysqli_stmt_fetch($stmt)) 
                            {
                                $uitvoerdersArray = unserialize(base64_decode($uitvoerders)); // zet de code van de database om in de array.
                                foreach($uitvoerdersArray as $input)
                                {
                                    if($input == $studentNummer)//wanneer een uitvoerder met het studentnummer overeenkomt 
                                    {
                                        array_push($labjournalenArray,$labjournaalID);  // zet het ID van labjournaal in de nieuwe array.
                                    }
                                }
                            }
                            $labjournalen = ""; 
                            foreach ($labjournalenArray as $labjournaal) 
                            {
                                if(empty($labjournalen))// als labjournalen variabele nog leeg is begin met de where statement. Om de labjournalen op te halen
                                {
                                    $labjournalen .= " WHERE ((labjournaalID =".$labjournaal;
                                }
                                else// anders de OR statement gebruiken om labjournalen op te halen.
                                {
                                    $labjournalen .= " OR labjournaalID =".$labjournaal;
                                }
                            } $labjournalen .= ")"; // wanneer de foreach is afgelopen sluit af met een haakje.
                            $queryError = false; // er is geen error de de queryerror is false.
                            
                        }else {$queryError = true;}// wanneer er geen labjournalen op te halen zijn is de true.
                        querysluiten(); // de database connectie sluiten. 
                        if(!$queryError)// wanneer er labjournalen zijn gevonden.
                        {                   
                            $sql = '
                            SELECT studentNaam,labjournaalTitel,experimentDatum,vak,l.jaar,labjournaalID
                            FROM labjournaal as l
                            JOIN student AS s ON l.studentID = s.studentID'; //haal de gegevens van de labjournalen op.
                            $sql .= $labjournalen; // voeg de labjournalen array toe aan de query
                            $sqljaar = "";
                            if(!empty($_GET['jaar'])) // pas de filter van het geselecteerde jaar toe.
                            {
                                $jaarlaag = $_GET['jaar'];
                                $sqljaar .= ' AND l.jaar = '.$jaarlaag;
                                if($_SESSION['SorD'] == "Student") // wanneer student is ingelogd controleren op studentID.
                                {
                                    $sqljaar .= ' AND s.studentID = '.$_SESSION["StudentID"];  
                                }       
                            }
                            else //wanneer geen jaar is geselecteerd zet jaar op nul.
                            {
                                $jaarlaag = 0;
                                if($_SESSION['SorD'] == "Student")
                                {
                                        $sqljaar .= ' AND s.studentID = '.$_SESSION["StudentID"].' ';   // wanneer student is ingelogd controleren op studentID.
                                }       
                            }
                            $sql .= $sqljaar.' AND l.vak = "'.$selected.'" ';    // voeg de vak filter toe aan de query.     
                            $sql .= ') OR (l.studentID = s.studentID AND l.vak = "'.$selected.'" '.$sqljaar.')  '; // laat de labjournalen ook zien waar de ingelogde student auteur van is.       
                            $sql .= 'ORDER BY experimentDatum DESC '; 
                            if(!isset($_GET['page']) || $_GET['page'] == 0){
                                $sql = $sql.'LIMIT 5'; 
                            } else {
                                $counter = $_GET['page'];
                                $limit = 20;
                                $offset = $limit*($counter-1);
                                $sql = $sql.'LIMIT '.$limit.' OFFSET '.$offset.'';
                            }
                            queryAanmaken($sql);
                            mysqli_stmt_bind_result($stmt, $studentNaam, $labjournaalTitel,$experimentDatum, $vak, $jaar,$labjournaalID);
                            mysqli_stmt_store_result($stmt);
                            if(mysqli_stmt_num_rows($stmt) != 0) // print de tabel uit met de labjournalen.
                            {
                                echo "<table class='LTable'><tr><th>Titel</th><th>Auteur</th><th>Experiment datum</th><th>Vakken</th><th>Jaar</th><th>download</th><th>Bekijken</th></tr>";
                                while(mysqli_stmt_fetch($stmt))
                                {
                                    echo '<tr>
                                    <td>'.$labjournaalTitel.'</td>
                                    <td>'.$studentNaam.'</td>
                                    <td>'.$experimentDatum.'</td>
                                    <td>'.$vak.'</td>
                                    <td>'.$jaar.'</td>
                                    <td><a class="labjournaalLink" href="../Include/downloadLabjournaal.inc.php?ID='.$labjournaalID .'"> <i class="fas fa-download"></i> </a></td>
                                    <td><a class="labjournaalLink" href="labjournaalBekijken.php?ID='.$labjournaalID .'">Bekijken </a> </td>
                                    </tr>' ;
                                }
                                echo"</table>";
                                
                            }
                            querySluiten();
                            if(!isset($_GET['page']) || $_GET['page'] == 0){
                                $url = 'labjournalenBekijken.php?jaar='.$jaarlaag.'&page=';
                                $next = $url.'1';
                                echo'<a class="Lbutton" href='.$next.'>Alle Labjournalen</a>';
                            } else {
                                $url = 'labjournalenBekijken.php?jaar='.$jaarlaag.'&page=';
                                $next = $_GET['page']+1;
                                $back = $_GET['page']-1;
        
                                echo'<a class="Lbutton" href="'.$url.$next.'">Volgende pagina</a>';
                                echo'<a class="Lbutton" href="'.$url.$back.'">Vorige pagina</a>';
                            }
                        }else //wanneer er geen labjournalen zijn gevonden.
                        { 
                            echo '<div class="bericht">
                                    <b>Er zijn geen labjournalen om te bekijken.</b><hr>
                                </div>';
                        }
                    ?>
                </div>
            </div>
        </main>
        <?php 
            /* Footer */
            include_once '../Include/Footer.php';
        ?>    
    </body>
</html>