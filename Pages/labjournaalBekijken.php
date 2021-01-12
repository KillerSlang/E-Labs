<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cda83c7af3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Nieuw Labjournaal</title>
</head>

<body>
<?PHP
    /* Header */
    include_once '../Include/Header.php';
	include_once '../Include/Dbh.inc.php';
?>

<main id="Labjournaal">
    <div class="PageTitle">
        <h1>Labjournaal</h1>
        <hr>
    </div>
    <div class="whitebg">
        <div class="content">
            <?PHP
				if(!empty($_GET['ID']))// haal het ID op uit de GET en filter deze.
				{
					$ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
                }else{ $ID = 0; }               
                queryAanmaken(
                    'SELECT labjournaalTitel,uitvoerders,experimentdatum,
                    experimentBeginDatum,experimentEindDatum,veiligheid,doel,bijlageWaarnemingen,
                    hypothese,materialen,methode,bijlageMeetresultaten,logboek,bijlageLogboek,
                    observaties,bijlageObservaties,weeggegevens,bijlageWeeggegevens,
                    bijlageAfbeelding,vak,jaar,beoordeling,docentID
                    FROM labjournaal
                    WHERE labjournaalID = ?'
                    ,"i",$ID); // maak de query aan en vul het vraagteken met ID.
                mysqli_stmt_bind_result($stmt, $labjournaalTitel, $uitvoerders, $experimentDatum, $experimentBeginDatum, $experimentEindDatum, 
                                        $veiligheid, $doel, $bijlageWaarnemingen, $hypothese, $materialen, $methode, $bijlageMeetresultaten, $logboek,
                                        $bijlageLogboek, $observaties, $bijlageObservaties, $weeggegevens, $bijlageWeeggegevens, $bijlageAfbeelding,
                                        $vak, $jaar, $beoordeling, $docent); // bind de resultaten.                
                mysqli_stmt_store_result($stmt);  // sla de resultaten op.               
                while (mysqli_stmt_fetch($stmt)) {} 
                    /* maak de while statement aan en sluit deze.
                    omdat er altijd maar 1 resultaat is wordt deze meteen gesloten zodat de database connectie
                    weer kan worden gebruikt. */
                    querySluiten(); // sluit de connectie met de database                    
                echo '
                    <p>
                        <label>Titel experiment: * </label>'
                        .$labjournaalTitel.
                    '</p>';                               
                echo'
                    <p>
                        <label>Uitvoerders: * </label>';
                        $uitvoerdersArray = unserialize(base64_decode($uitvoerders)); // haal de uitvoerders array uit de database.
                        foreach($uitvoerdersArray as $uitvoerder)
                        {
                            queryAanmaken(  //zoek de naam van de uitvoerders op in de database.
                                'SELECT studentNaam
                                FROM student
                                WHERE studentNummer = ?'
                                ,"i",$uitvoerder);
                            mysqli_stmt_bind_result($stmt, $studentNaam);
                            mysqli_stmt_store_result($stmt);
                            while (mysqli_stmt_fetch($stmt)) //print de namen van de uitvoerders uit.
                            {
                                echo '<br> &nbsp; &nbsp; &nbsp;- '.$studentNaam;
                            }
                            querySluiten();
                        } 
                echo'</p>
                    <p>                    
                        <label>Experiment datum: * </label>'.
                        $experimentDatum.
                    '</p>
                    <p>
                        <label>Start datum experiment: </label>'.
                        $experimentBeginDatum.
                    '</p>
                    <p>
                        <label>Eind datum experiment: </label>'.
                        $experimentEindDatum.
                    '</p>
                    <p>             
                        <label>Veiligheid: </label>';
                            if(!empty($veiligheid)){ // wanneer er een bestand is geupload
                                echo'<a class="downloadLink" target="_blank" href="'.$veiligheid.'">'.$veiligheid.'</a><br>'; //print de downloadlink uit.
                                $extension = explode(".", $veiligheid);
                                if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){ // wanneer het bestand een afbeelding is
                                    echo '<img class="imageBekijken" src="'.$veiligheid.'">'; // print de afbeelding
                                }
                            } else { // wanneer er geen bestand is geupload
                                echo'Geen bestand geupload.';
                            }
              echo '</p>
                    <p>        
                        <label>Doel: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $doel.'
                        </textarea>        
                    </p>
                    <p>
                        <label>Download waarnemingen: </label>';
                        if(!empty($bijlageWaarnemingen)){// wanneer er een bestand is geupload
                            echo'<a class="downloadLink" target="_blank" href="'.$bijlageWaarnemingen.'">'.$bijlageWaarnemingen.'</a><br>
                            <img class="imageBekijken" src="'.$bijlageWaarnemingen.'">'; //print de downloadlink uit en print de afbeelding. Hier hoeft geen check op omdat je alleen maar afbeeldingen kan uploaden.
                        } else {// wanneer er geen bestand is geupload
                            echo'Geen bestand geupload.';
                        }
               echo'</p>
                    <p>                
                        <label>Hypothese: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $hypothese.'
                        </textarea>
                    </p>
                    <p>        
                        <label>Materialen: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $materialen.'
                        </textarea>
                    </p>
                    <p>
                        <label>Methode: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $methode.'
                        </textarea>
                    </p>
                    <p>
                        <label>Download meetresultaten: </label>';
                        if(!empty($bijlageMeetresultaten)){// wanneer er een bestand is geupload
                            echo'<a class="downloadLink" target="_blank" href="'.$bijlageMeetresultaten.'">'.$bijlageMeetresultaten.'</a><br>';//print de downloadlink uit.
                            $extension = explode(".", $bijlageMeetresultaten);// wanneer het bestand een afbeelding is
                            if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                                echo '<img class="imageBekijken" src="'.$bijlageMeetresultaten.'">';// print de afbeelding
                            }  
                        } else {// wanneer er geen bestand is geupload
                            echo'Geen bestand geupload.';
                        }
               echo '</p>        
                    <p>
                        <label>Logboek: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $logboek.
                        '</textarea>
                    </p>
                    <p>                    
                        <label>Download logboek: </label>';
                        if(!empty($bijlageLogboek)){// wanneer er een bestand is geupload
                            echo'<a class="downloadLink" target="_blank" href="'.$bijlageLogboek.'">'.$bijlageLogboek.'</a><br>';//print de downloadlink uit. Hier kunnen geen afbeeldingen geupload worden dus check is niet nodig.
                        } else {// wanneer er geen bestand is geupload
                            echo'Geen bestand geupload.';
                        }
                echo'</p>
                    <p>
                        <label>Observaties: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $observaties.'
                        </textarea>
                    </p>
                    <p>
                        <label>Download observatie: </label>';
                        if(!empty($bijlageObservaties)){// wanneer er een bestand is geupload
                            echo'<a class="downloadLink" target="_blank" href="'.$bijlageObservaties.'">'.$bijlageObservaties.'</a><br>';//print de downloadlink uit.
                            $extension = explode(".", $bijlageObservaties);
                            if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){// wanneer het bestand een afbeelding is
                                echo '<img class="imageBekijken" src="'.$bijlageObservaties.'">';// print de afbeelding
                            }
                        } else {// wanneer er geen bestand is geupload
                            echo'Geen bestand geupload.';
                        }
              echo '</p>
                    <p>        
                        <label>Weeggegevens: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $weeggegevens.'
                        </textarea>
                    </p>
                    <p>
                        <label>Weeggegevens: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $weeggegevens.'
                        </textarea>
                    </p>
                    <p>
                        <label>Download weeggegevens: </label>';
                        if(!empty($bijlageWeeggegevens)){// wanneer er een bestand is geupload
                            echo'<a class="downloadLink" target="_blank" href="'.$bijlageWeeggegevens.'">'.$bijlageWeeggegevens.'</a><br>';//print de downloadlink uit. Hier kunnen geen afbeeldingen geupload worden dus check is niet nodig.
                        } else {// wanneer er geen bestand is geupload
                            echo'Geen bestand geupload.';
                        }
                echo'</p>
                    <p>        
                        <label>Download afbeeldingen: </label>';
                        if(!empty($bijlageAfbeelding)){// wanneer er een bestand is geupload
                            echo'<a class="downloadLink" target="_blank" href="'.$bijlageAfbeelding.'">'.$bijlageAfbeelding.'</a><br>
                            <img class="imageBekijken" src="'.$bijlageAfbeelding.'">';//print de downloadlink uit en print de afbeelding. Hier hoeft geen check op omdat je alleen maar afbeeldingen kan uploaden.
                        } else {// wanneer er geen bestand is geupload
                            echo'Geen bestand geupload.';
                        }
                echo'</p>
                    
                        <label>Vak: *</label>
                        <div ID="Vakken">';
                            if ($vak == "BML")
                            {
                                echo'
                                <input type="radio" id="BML" name="LVak" value="BML" checked>
                                <label>BML</label><br>
                                <input type="radio" id="Chemie" name="LVak" value="Chemie">
                                <label>Chemie</label>';
                            }
                            else
                            {
                                echo'
                                <input type="radio" id="BML" name="LVak" value="BML">
                                <label>BML</label><br>
                                <input type="radio" id="Chemie" name="LVak" value="Chemie" checked>
                                <label>Chemie</label>';
                            }
                  echo '</div>  
                                                 
                    
                        <label>Jaar: *</label>
                        <div id="Jaren">';
                        if ($jaar == "1") 
                        {
                            echo '<input type="radio" id="Jaar1" name="PJaar" value="1" checked>
                            <label>Jaar 1</label><br>
                            <input type="radio" id="Jaar2" name="PJaar" value="2">
                            <label>Jaar 2</label><br>
                            <input type="radio" id="Jaar3" name="PJaar" value="3">
                            <label>Jaar 3</label>';
                        } elseif ($jaar == "2")
                        {
                            echo '<input type="radio" id="Jaar1" name="PJaar" value="1">
                            <label>Jaar 1</label><br>
                            <input type="radio" id="Jaar2" name="PJaar" value="2" checked>
                            <label>Jaar 2</label><br>
                            <input type="radio" id="Jaar3" name="PJaar" value="3">
                            <label>Jaar 3</label>';
                        } elseif ($jaar == "3") 
                        {
                            echo '<input type="radio" id="Jaar1" name="PJaar" value="1" >
                            <label>Jaar 1</label><br>
                            <input type="radio" id="Jaar2" name="PJaar" value="2">
                            <label>Jaar 2</label><br>
                            <input type="radio" id="Jaar3" name="PJaar" value="3" checked>
                            <label>Jaar 3</label>';
                        } else {
                            echo '<input type="radio" id="Jaar1" name="PJaar" value="1" checked>
                            <label>Jaar 1</label><br>
                            <input type="radio" id="Jaar2" name="PJaar" value="2">
                            <label>Jaar 2</label><br>
                            <input type="radio" id="Jaar3" name="PJaar" value="3">
                            <label>Jaar 3</label>';
                        }
                        echo '    
                        </div>
                    ';   
                    if($_SESSION['SorD'] == "Docent") 
                    {
                        echo '
                        <form class="" action="../Include/toevoegenBeoordeling.inc.php?ID='.$ID.'" method="post">
                            <p>
                                <label>Beoordeling: </label>';
                                if (empty($beoordeling)){
                                    echo '<input type="number" id="beoordeling" name="beoordeling" min="0" max="10" value="0" step="0.1" style="width: 3em">';
                                } else {
                                    echo $beoordeling;
                                };'
                                
                            </p>';
                            if(!empty($docent))
                            {
                                queryAanmaken(
                                'SELECT docentNaam
                                 FROM docent
                                 WHERE docentID = ?
                                ',
                                "i",
                                $docent
                                );
                                mysqli_stmt_bind_result($stmt, $docentNaam);
                                mysqli_stmt_store_result($stmt);
                                if(mysqli_stmt_num_rows($stmt) != 0)
                                {
                                    while (mysqli_stmt_fetch($stmt)) 
                                    {
                                        echo '
                                        <p>
                                        <label>Beoordeeld door: </label>';
                                        if (!empty($docentNaam)){
                                            echo $docentNaam;
                                        } else {
                                            echo 'Geen beoordeling gegeven';
                                        }'
                                        </p>';
                                    }
                                }
                                querySluiten();
                            
                             }; 
                             echo '<br>
                            <input class="bluebtn" type="Submit" id="beoordelingSubmit" name="beoordelingSubmit" value="Opslaan">
                        </form>';
                     
                    }  else 
                    {
                        echo '
                        <p>
                            <label>Beoordeling: </label>';
                            if (!empty($beoordeling)){
                                echo $beoordeling;
                            }else {
                                echo 'Geen beoordeling gegeven';
                            }
                  echo '</p>';

                        if(!empty($docent))
                        {
                            queryAanmaken(
                            'SELECT docentNaam
                             FROM docent
                             WHERE docentID = ?
                            ',
                            "i",
                            $docent
                            );
                            mysqli_stmt_bind_result($stmt, $docentNaam);
                            mysqli_stmt_store_result($stmt);
                            if(mysqli_stmt_num_rows($stmt) != 0)
                            {
                                while (mysqli_stmt_fetch($stmt)) 
                                {
                                    echo '
                                    <p>
                                    <label>Beoordeeld door: </label>';
                                    if (!empty($docentNaam)){
                                        echo $docentNaam;
                                    } else {
                                        echo 'Geen beoordeling gegeven';
                                    }
                                    '
                                    </p>';
                                }
                            }
                            querySluiten();
                         };

                    }                     
            ?>
        </div>
    </div>
</main>
<script type="text/javascript"> //functie voor het automatisch instellen van de hoogte voor de tekstvakken.
    textarea = document.querySelectorAll(".autoresizingBekijken");
    textarea.forEach(function(ta){
        var event = new CustomEvent("resizeAfterRefresh");
        ta.addEventListener('input', autoResize, false);
        ta.addEventListener('resizeAfterRefresh', autoResize, false);
        ta.dispatchEvent(event);
    })
    function autoResize() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    }
</script>            
<?php
    /* Footer */
    include_once '../Include/Footer.php';
?>
</body>
</html>