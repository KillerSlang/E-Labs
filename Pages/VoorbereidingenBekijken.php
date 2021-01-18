<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="stylesheet" href="../Css/Responsive.css">
        <?php
        if($_COOKIE['taal'] == 'english') {
            echo "<title>View Preparations</title>";
        }else {
            echo "<title>Voorbereidingen Bekijken</title>";
        }
        ?>
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
                <h1>Te bekijken Voorbereidingen</h1>
                <hr>
            </div>
            <div class="whitebg">
                <div id="Lcontent6" class="content">
                    <a class="bluebtn Lbutton" id="lbuttonLeft" href='voorbereidingen.php?jaar=0'>Bewerk Voorbereidingen</a>
                    <a class="bluebtn Lbutton <?=($_GET["jaar"] == 1) ? "Pselected" : ""?>"  href="VoorbereidingenBekijken.php?jaar=1"><?=$Jaar1?></a>
                    <a class="bluebtn Lbutton <?=($_GET["jaar"] == 2) ? "Pselected" : ""?>"  href="VoorbereidingenBekijken.php?jaar=2"><?=$Jaar2?></a>
                    <a class="bluebtn Lbutton <?=($_GET["jaar"] == 3) ? "Pselected" : ""?>"  href="VoorbereidingenBekijken.php?jaar=3"><?=$Jaar3?></a>
                    <a class="bluebtn Lbutton <?=($_GET["jaar"] == 0) ? "Pselected" : ""?>"  href="VoorbereidingenBekijken.php?jaar=0"><?=$JaarAlle?></a>
                    <!-- Formulier van de select button van BML en Chemie -->
                    <form action="VoorbereidingenBekijken.php?jaar=<?=$_GET["jaar"]?>" name="selectform" method="post">
                        <select class="bluebtn Lbutton" name="vak" onchange="this.form.submit();">                        
                            <?PHP
                                echo get_options($selected);
                            ?>
                        </select>
                    </form>
                    <br>
                    <?php
                        queryAanmaken('SELECT studentNummer
                                        FROM student
                                        WHERE studentID = ?',
                                        "i",
                                         $_SESSION["StudentID"]);// zoek het studentnummer op van de ingelogde student.
                        mysqli_stmt_bind_result($stmt,$studentNummer);
                        mysqli_stmt_store_result($stmt);
                        if(mysqli_stmt_num_rows($stmt) != 0) // wanneer er resultaat is
                        {
                            while (mysqli_stmt_fetch($stmt)) 
                            {
                                $studentNummer = $studentNummer;
                            }
                        }

                        querysluiten(); 
                        queryaanmaken('SELECT uitvoerders,voorbereidingID
                                    FROM voorbereiding');// haal de uitvoerders array en labjournaalID op uit de database.
                        mysqli_stmt_bind_result($stmt,$uitvoerders,$voorbereidingID);
                        mysqli_stmt_store_result($stmt);  
                        if(mysqli_stmt_num_rows($stmt) != 0) // wanneer er resultaat is.
                        {            
                            $voorbereidingArray = array(); // maak een nieuwe array aan.             
                            while (mysqli_stmt_fetch($stmt)) 
                            {
                                $voorbereidingArray = unserialize(base64_decode($uitvoerders)); // zet de code van de database om in de array.
                                foreach($voorbereidingArray as $input)
                                {
                                    if($input == $studentNummer)//wanneer een uitvoerder met het studentnummer overeenkomt 
                                    {
                                        array_push($voorbereidingArray,$voorbereidingID);  // zet het ID van labjournaal in de nieuwe array.
                                    }
                                }
                            }
                            $queryError = false; // er is geen error dus de queryerror is false.
                            
                        }else {$queryError = true;  }// wanneer er geen labjournalen op te halen zijn is de true.
                            queryAanmakenAdvanced(
                               'SELECT studentNaam,voorbereidingTitel,voorbereidingDatum,vak,l.jaar,voorbereidingID
                                FROM voorbereiding as l
                                JOIN student AS s ON l.studentID = s.studentID',
                                false // deze boolean is ervoor om de query uit te voeren ja of nee. In dit geval dus nog niet.
                            ); // er wordt nu dus ook nog geen connectie gemaakt met de database.
                            $voorbereidingen = true;
                            if(!empty($voorbereidingArray))
                            { 
                                foreach ($voorbereidingArray as $voorbereiding) 
                                {
                                    if($voorbereidingen)// als labjournalen variabele nog leeg is begin met de where statement. Om de labjournalen op te halen
                                    {
                                        $voorbereidingen = false;
                                        queryAanmakenAdvanced(
                                            ' WHERE ((voorbereidingID = ? ',
                                            false,
                                            "i",
                                            $voorbereiding
                                        );
                                    }
                                    else// anders de OR statement gebruiken om labjournalen op te halen.
                                    {
                                    // $labjournalen .= " OR labjournaalID =".$labjournaal;
                                    queryAanmakenAdvanced(
                                        ' OR voorbereidingID = ? ',
                                        false,
                                        "i",
                                        $voorbereiding
                                    );
                                    }
                                } queryAanmakenAdvanced (")",false); // wanneer de foreach is afgelopen sluit af met een haakje.
                                if(!empty($_GET['jaar'])) // pas de filter van het geselecteerde jaar toe.
                                {
                                    $jaarlaag = $_GET['jaar'];
                                    queryAanmakenAdvanced (
                                        ' AND l.jaar = ? ',
                                        false,
                                        "i",
                                        $jaarlaag
                                    );
                                    if($_SESSION['SorD'] == "Student") // wanneer student is ingelogd controleren op studentID.
                                    {
                                        queryAanmakenAdvanced(
                                            ' AND s.studentID = ? ',
                                            false,
                                            "i",
                                            $_SESSION["StudentID"]
                                        );  
                                    }       
                                }
                                else //wanneer geen jaar is geselecteerd zet jaar op nul.
                                {
                                    $jaarlaag = 0;
                                    if($_SESSION['SorD'] == "Student")
                                    {
                                        queryAanmakenAdvanced(
                                            ' AND s.studentID = ? ',
                                            false,
                                            "i",
                                            $_SESSION["StudentID"]                                        
                                        );// wanneer student is ingelogd controleren op studentID.
                                    }       
                                }
                                querysluiten(); // de database connectie sluiten. 
                            }
                            else
                            {
                                if(!empty($_GET['jaar'])) // pas de filter van het geselecteerde jaar toe.
                                {
                                    $jaarlaag = $_GET['jaar'];
                                    queryAanmakenAdvanced (
                                        ' WHERE (l.jaar = ? ',
                                        false,
                                        "i",
                                        $jaarlaag
                                    );
                                    if($_SESSION['SorD'] == "Student") // wanneer student is ingelogd controleren op studentID.
                                    {
                                        queryAanmakenAdvanced(
                                            ' AND s.studentID = ? ',
                                            false,
                                            "i",
                                            $_SESSION["StudentID"]
                                        );  
                                    }       
                                }
                                else //wanneer geen jaar is geselecteerd zet jaar op nul.
                                {
                                    $jaarlaag = 0;
                                    if($_SESSION['SorD'] == "Student")
                                    {
                                        queryAanmakenAdvanced(
                                            ' WHERE (s.studentID = ? ',
                                            false,
                                            "i",
                                            $_SESSION["StudentID"]                                        
                                        );// wanneer student is ingelogd controleren op studentID.
                                    }       
                                }
                                querysluiten(); // de database connectie sluiten. 
                            }
                            queryAanmakenAdvanced(
                                ' AND l.vak = ? ',
                                false,
                                "s",
                                $selected
                            );    // voeg de vak filter toe aan de query.     
                            queryAanmakenAdvanced(
                                ') OR (l.studentID = s.studentID AND l.vak = ? ',
                                false,
                                "s",
                                $selected // laat de labjournalen ook zien waar de ingelogde student auteur van is.  
                            );   
                             
                            if(!empty($_GET['jaar'])) // pas de filter van het geselecteerde jaar toe.
                            {
                                $jaarlaag = $_GET['jaar'];
                                queryAanmakenAdvanced (
                                    ' AND l.jaar = ? )',
                                    false,
                                    "i",
                                    $jaarlaag
                                );     
                            }
                            else //wanneer geen jaar is geselecteerd zet jaar op nul.
                            {
                                $jaarlaag = 0;
                                    queryAanmakenAdvanced(
                                        ' ) ',
                                        false,                                                                                
                                    );// wanneer student is ingelogd controleren op studentID.      
                            }  
                            queryAanmakenAdvanced(
                                'ORDER BY voorbereidingDatum DESC ',
                                false); 
                            if(!isset($_GET['page']) || $_GET['page'] == 0){
                                queryAanmakenAdvanced('LIMIT 5',false); 
                            } else {
                                $counter = $_GET['page'];
                                $limit = 20;
                                $offset = $limit*($counter-1);
                                queryAanmakenAdvanced(
                                    'LIMIT ? OFFSET ?',
                                    false,
                                    "ii",
                                    $limit,$offset
                                );
                            }
                            queryAanmakenAdvanced(
                                ' ',
                                true
                            );
                            mysqli_stmt_bind_result($stmt, $studentNaam, $voorbereidingTitel,$voorbereidingDatum, $vak, $jaar,$voorbereidingID);
                            mysqli_stmt_store_result($stmt);
                            if(mysqli_stmt_num_rows($stmt) != 0) // print de tabel uit met de labjournalen.
                            {
                                echo "<table class='LTable'><tr><th>Titel</th><th>Auteur</th><th>Voorbereiding datum</th><th>Vakken</th><th>Jaar</th><th>download</th><th>Bekijken</th></tr>";
                                while(mysqli_stmt_fetch($stmt))
                                {
                                    echo '<tr>
                                    <td>'.$voorbereidingTitel.'</td>
                                    <td>'.$studentNaam.'</td>
                                    <td>'.$voorbereidingDatum.'</td>
                                    <td>'.$vak.'</td>
                                    <td>'.$jaar.'</td>
                                    <td><a class="labjournaalLink" href="../Include/downloadVoorbereiding.inc.php?ID='.$voorbereidingID .'"> <i class="fa fa-download"></i> </a></td>
                                    <td><a class="labjournaalLink" href="VoorbereidingBekijken.php?ID='.$voorbereidingID .'">Bekijken </a> </td>
                                    </tr>' ;
                                }
                                echo"</table>";
                                
                            }
                            querySluiten();
                            if(!isset($_GET['page']) || $_GET['page'] == 0){
                                $url = 'VoorbereidingenBekijken.php?jaar='.$jaarlaag.'&page=';
                                $next = $url.'1';
                                echo'<a class="bluebtn Lbutton Lpages4" href='.$url.'1>'.$VoorbereidingAlle.'</a>';
                            } else {
                                $url = 'VoorbereidingenBekijken.php?jaar='.$jaarlaag.'&page=';
                                $next = $_GET['page']+1;
                                $back = $_GET['page']-1;
        
                                echo'<a class="bluebtn Lbutton Lpages1"  href='.$url.$back.'>'.$PaginaVorige.'</a>';
                                echo'<p class="Lpages2">'.$_GET['page'].'</p>';
                                echo'<a class="bluebtn Lbutton Lpages3" href='.$url.$next.'>'.$PaginaVolgende.'</a>';
                            }
                    
                            if($queryError)
                            { 
                                echo '<div class="bericht">
                                    <b>'.$VoorbereidingError.'.</b><hr>
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