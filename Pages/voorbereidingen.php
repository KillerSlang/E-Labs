<!DOCTYPE HTML>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cda83c7af3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    
    <title>Voorbereidingen</title>
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
            <h1>Voorbereidingen Overzicht</h1>
            <hr>
        </div>
        <div class="whitebg">
            <div class="content">

            <?PHP
                        if($_SESSION['SorD'] == "Student") // wanneer een student is ingelogd is de Nieuwe voorbereiding knop en de bekijk knop beschikbaar.
                        {
                            echo '<a class="bluebtn"  href="voorbereidingenaanmaak.php?NEW">Nieuwe voorbereiding</a>
                                <a class="bluebtn" id="PbuttonLeft" href="voorbereidingBekijken.php">Bekijk voorbereiding</a>';
                        }
                        echo ' 
                        <a class="bluebtn"  href="voorbereidingen.php?jaar=3">Jaar 3</a>
                        <a class="bluebtn"  href="voorbereidingen.php?jaar=2">Jaar 2</a>
                        <a class="bluebtn"  href="voorbereidingen.php?jaar=1">Jaar 1</a>
                        <a class="bluebtn"  href="voorbereidingen.php?jaar=0">Alle jaren</a>';
                    ?>
                        <!-- Formulier van de select button van BML en Chemie -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="selectform" method="post"> 
                            <select class="bluebtn"  name="vak" onchange="this.form.submit();">                        
                                <?PHP
                                    echo get_options($selected);
                                ?>
                            </select>
                        </form>
               

                <?PHP
                            // Bouw de query via de sql variabele op.
                            queryAanmakenAdvanced(
                                'SELECT studentID,voorbereidingTitel,voorbereidingDatum,vak,v.jaar,voorbereidingID
                                FROM voorbereiding as v
                                JOIN student AS s ON v.studentID = s.studentID
                                ',false);    
                            if(!empty($_SESSION['jaar'])) // wanneer er op een jaar knop is gedrukt.
                            {
                                $jaarlaag = $_SESSION['jaar']; // haal het jaar uit de get
                                queryAanmakenAdvanced(
                                    ' WHERE v.jaar = ?',
                                    false,
                                    "i",
                                    $jaarlaag
                                ); // Voeg de Where statement met jaar toe aan de query.
                                if($_SESSION['SorD'] == "Student")// wanneer een student ingelogd is zal er gecontroleerd worden of het studentID overeenkomt.
                                {
                                    queryAanmakenAdvanced(
                                        ' AND s.studentID = ? ',
                                        false,
                                        "i",
                                        $_SESSION["StudentID"]
                                    );  
                                }       
                            }
                            else // anders wordt er alleen gecontroleerd op de student
                            {
                                $jaarlaag = 0; 
                                if($_SESSION['SorD'] == "Student")
                                {
                                    queryAanmakenAdvanced(
                                        ' WHERE s.studentID = ? ',
                                        false,
                                        "i",
                                        $_SESSION["StudentID"]
                                    );
                                }       
                            }
                            queryAanmakenAdvanced(
                                ' AND v.vak = ? ',
                                false,
                                "s",
                                $selected
                            );// voegt toe aan de query welk vak geselecteerd is.
                            if($_SESSION['SorD'] == "Student") // voor een docent is dit een bekijk pagina. Dus is deze query niet nodig bij de student wel.
                            { 
                                queryAanmakenAdvanced(
                                    ' AND v.bewerkTotDatum >= NOW()',
                                    false
                                ); // controleer de bewerkDatum met de datum van Nu.
                            }                  
                            queryAanmakenAdvanced(
                                'ORDER BY experimentDatum DESC ',
                                false
                            ); // de volgorde van de labjournalen is via de experiment datum.
                
                            if(!isset($_GET['page']) || $_GET['page'] == 0){
                                queryAanmakenAdvanced('LIMIT 5',false); 
                            } else {
                                $counter = $_GET['page'];
                                $limit = 20;
                                $offset = $limit*($counter-1);
                                //$sql = $sql.'LIMIT '.$limit.' OFFSET '.$offset.'';
                                queryAanmakenAdvanced(
                                    'LIMIT ? OFFSET ?',
                                    false,
                                    "ii",
                                    $limit,$offset
                                );
                            }
                            queryAanmakenAdvanced(' ',true); // de opgebouwde query wordt via deze functie uitgevoerd.
                            mysqli_stmt_bind_result($stmt, $studentID, $voorbereidingTitel, $voorbereidingDatum, $vak, $jaar, $voorbereidingID);
                            mysqli_stmt_store_result($stmt);
                            if(mysqli_stmt_num_rows($stmt) != 0) // wanneer er resultaten zijn wordt de tabel uitgeprint en de knoppen onderaan ook weergeven anders niet.
                            {
                                echo "<table class='LTable'><tr> <th>Titel</th><th>Auteur</th><th>Experiment datum</th><th>Vakken</th><th>Jaar</th><th>download</th>";
                                if($_SESSION["SorD"] == "Student")// een student heeft na het maken van het labjournaal 1 dag om deze te bewerken of te verwijderen.
                                {
                                    echo"<th>Bewerken</th><th>Verwijderen</th>";
                                }else{ echo"<th>Bekijken</th>";} // een docent kan de labjournalen alleen bekijken.
                                echo '</tr>'; // table row sluiten.
                                while(mysqli_stmt_fetch($stmt)) // alle resultaten in een rij van de tabel zetten.
                                {
                                    echo '<tr>
                                    <td>'.$voorbereidingTitel.'</td>
                                    <td>'.$studentID.'</td>
                                    <td>'.$voorbereidingDatum.'</td>
                                    <td>'.$vak.'</td>
                                    <td>'.$jaar.'</td>
                                    <td> <a class="labjournaalLink" href="../Include/downloadLabjournaal.inc.php?ID='.$voorbereidingID .'"> <i class="fas fa-download"></i> </a> </td>';
                                    
                                    if($_SESSION["SorD"] == "Student") // de bewerk en de verwijder-knop van de student printen.
                                    {
                                        echo'<td> <a class="labjournaalLink" href="labjournaalBewerk.php?NEW&ID='.$voorbereidingID .'">Bewerken </a></td>';
                                        echo'<td> <a class="labjournaalLink" href="../Include/deleteLabjournaal.inc.php?ID='.$voorbereidingID .'"> <i class="fas fa-trash-alt"></i> </a> </td>';
                                    }else{ echo'<td> <a class="labjournaalLink" href="labjournaalBekijken.php?ID='.$voorbereidingID .'">Bekijken</a></td>';} // de bekijken-knop van de student printen.
                                    
                                    echo '</tr>' ;
                                }
                                echo"</table>";
                                $queryError = false;
                            }else {$queryError = true;}
                            if(!isset($_GET['page']) || $_GET['page'] == 0){ // de knoppen printen om door de labjournalen heen te gaan.
                                $url = 'labjournalen.php?jaar='.$jaarlaag.'&page=';
                                $next = $url.'1';
                                echo'<a class="Lbutton"  href='.$next.'>Alle Labjournalen</a>';
                            } else {
                                $url = 'labjournalen.php?jaar='.$jaarlaag.'&page=';
                                $next = $_GET['page']+1;
                                $back = $_GET['page']-1;

                                echo'<a class="Lbutton"  href="'.$url.$next.'">Volgende pagina</a>';
                                echo'<a class="Lbutton"  href="'.$url.$back.'">Vorige pagina</a>';
                            }
                            querySluiten(); // de database connectie sluiten.
                            
                            if($queryError)
                            { 
                                echo '<div class="bericht">
                                        <b>Er zijn geen labjournalen om te bewerken.</b><hr>
                                    </div>';
                            }
                        ?>


                <?php /*
                    $sql = '
                    SELECT uitvoerders, voorbereidingTitel, voorbereidingDatum, vakken, jaar, voorbereidingID
                    FROM voorbereiding as v
                    JOIN student AS s ON v.studentID = s.studentID
                    ';
                    if(!empty($_GET['jaar']))
                    {
                        $jaarlaag = $_GET['jaar'];
                        $sql .= 'WHERE Jaar = '.$jaarlaag.' AND s.studentID = '.$_SESSION["StudentID"].' ';                        
                    }
                    else
                    {
                        $jaarlaag = 0;
                        $sql .= 'WHERE s.studentID = '.$_SESSION["StudentID"].' ';
                    }
                   $sql .= 'ORDER BY voorbereidingDatum DESC ';
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $sql = $sql.'LIMIT 5'; 
                    } else {
                        $counter = $_GET['page'];
                        $limit = 20;
                        $offset = $limit*($counter-1);
                        $sql = $sql.'LIMIT '.$limit.' OFFSET '.$offset.'';
                    } 

                    queryAanmaken($sql);
                    mysqli_stmt_bind_result($stmt, $uitvoerders, $voorbereidingTitel, $voorbereidingDatum, $vak, $Jaar, $voorbereidingID);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) != 0)
                    {
                        echo "<table class='PTable'><th>Titel</th><th>Auteur</th><th>Experiment datum</th><th>Vakken</th><th>Jaar</th><th>Bewerken</th>";
                        while(mysqli_stmt_fetch($stmt))
                        {
                            echo '<tr>
                            <td><a class="labjournaalTitel"href="voorbereidingBekijken.php?ID='.$voorbereidingID .'"</a>'.$voorbereidingTitel.'</td>
                            <td>'.$uitvoerders.'</td>
                            <td>'.$voorbereidingDatum.'</td>
                            <td>'.$vak.'</td>
                            <td>'.$Jaar.'</td>
                            <td><a class="labjournaalLink"href="voorbereidingBekijken.php?ID='.$voorbereidingID .'"</a>Bewerken</td>
                            </tr>' ;
                        }
                        echo"</table>";
                        
                    }
                    querySluiten();
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $url = 'voorbereidingen.php?jaar='.$jaarlaag.'&page=';
                        $next = $url.'1';
                        echo'<a class="bluebtn" id="Pbutton" href='.$next.'>Alle Voorbereidingen</a>';
                    } else {
                        $url = 'voorbereidingen.php?jaar='.$jaarlaag.'&page=';
                        $next = $_GET['page']+1;
                        $back = $_GET['page']-1;

                        echo'<a class="bluebtn" id="Pbutton" href="'.$url.$next.'">Volgende pagina</a>';
                        echo'<a class="bluebtn" id="Pbutton" href="'.$url.$back.'">Vorige pagina</a>';
                    }
              */  ?>
            </div>
        </div>
    </main>
    <?php 
    /* Footer */
    include_once '../Include/Footer.php';
    ?>    
</body>