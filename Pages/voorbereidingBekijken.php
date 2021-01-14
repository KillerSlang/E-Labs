<!DOCTYPE html>
<html>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <!--<script src="https://kit.fontawesome.com/cda83c7af3.js" crossorigin="anonymous"></script>-->
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Voorbereiding bekijken</title>
</head>

<body>
<?PHP
    /* Header */
    include_once '../Include/Header.php';
	include_once '../Include/Dbh.inc.php';
?>

<main id="Labjournaal">
    <div class="PageTitle">
        <h1>Voorbereiding</h1>
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
                    'SELECT voorbereidingTitel,voorbereidingDatum,materialen,methode,hypothese,
                    instellingenApparaten,voorbereidendeVragen,veiligheid,vak,uitvoerders,
                    uitvoeringsDatum,benodigdeFormules,jaar,bijlageTheorie,bijlageMaterialen,
                    bijlageMethode,bijlageVeiligheid,bijlageVoorbereidendevragen,doel,docentID,beoordeling
                    FROM voorbereiding
                    WHERE voorbereidingID = ?'
                    ,"i",$ID); // maak de query aan en vul het vraagteken met ID.
                mysqli_stmt_bind_result($stmt, $titelvoorbereiding,$voorbereidingsdatum,$materialen,$methode,$hypothese,
                                        $InstellingenApparaten,$voorbereidendevragen,$veiligheid,$vak,$uitvoerders,$uitvoeringsdatum,$benodigdeFormules,
                                        $jaar,$bijlageTheorie,$bijlageMaterialen,$bijlageMethode,$bijlageVeiligheid,$bijlageVoorbereidendevragen,
                                        $doel, $docent, $beoordeling); // bind de resultaten.                
                mysqli_stmt_store_result($stmt);  // sla de resultaten op.               
                while (mysqli_stmt_fetch($stmt)) {} 
                    /* maak de while statement aan en sluit deze.
                    omdat er altijd maar 1 resultaat is wordt deze meteen gesloten zodat de database connectie
                    weer kan worden gebruikt. */
                    querySluiten(); // sluit de connectie met de database                    
                echo '
                    <p>
                        <label>Titel Voorbereiding: * </label>'
                        .$titelvoorbereiding.
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
                        <label>voorbereidings datum: * </label>'.
                        $voorbereidingsdatum.
                    '</p>
                    <p>
                        <label>Uitvoerings Datum: </label>'.
                        $uitvoeringsdatum.
                    '</p>
                    <p>             
                        <label>Download theorie: </label>';
                            if(!empty($bijlageTheorie)){ // wanneer er een bestand is geupload
                                echo'<a class="downloadLink" target="_blank" href="'.$bijlageTheorie.'">'.$bijlageTheorie.'</a><br>'; //print de downloadlink uit.
                                $extension = explode(".", $bijlageTheorie);
                                if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){ // wanneer het bestand een afbeelding is
                                    echo '<img class="imageBekijken" src="'.$bijlageTheorie.'">'; // print de afbeelding
                                }
                            } else { // wanneer er geen bestand is geupload
                                echo'Geen bestand geupload.';
                            }
              echo '</p>
                    <p>        
                        <label>Benodigde Formules: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $benodigdeFormules.'
                        </textarea>        
                    </p>
                    <p>                
                        <label>Instellingen apparaten: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $InstellingenApparaten.'
                        </textarea>
                    </p>
                    <p>        
                        <label>Doel: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $doel.'
                        </textarea>
                    </p>
                    <p>
                        <label>Hypothese: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $hypothese.'
                        </textarea>
                    </p>
                    <p>
                        <label>Materialen: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $materialen.
                        '</textarea>
                    </p>
                    <p>
                        <label>Download Materialen: </label>';
                        if(!empty($bijlageMaterialen)){// wanneer er een bestand is geupload
                            echo'<a class="downloadLink" target="_blank" href="'.$bijlageMaterialen.'">'.$bijlageMaterialen.'</a><br>';
                            
                        } else {// wanneer er geen bestand is geupload
                            echo'Geen bestand geupload.';
                        }
               echo'</p>
                     <p>
                        <label>Methode: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $methode.'
                        </textarea>
                    </p>
                    <p>
                        <label>Download Methode: </label>';
                        if(!empty($bijlageMethode)){// wanneer er een bestand is geupload
                            echo'<a class="downloadLink" target="_blank" href="'.$bijlageMethode.'">'.$bijlageMethode.'</a><br>';//print de downloadlink uit.
                              
                        } else {// wanneer er geen bestand is geupload
                            echo'Geen bestand geupload.';
                        }
               echo '</p>        
                    <p>        
                        <label>Veiligheid: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $veiligheid.'
                        </textarea>
                    </p>
                    <p>                    
                        <label>Download Veiligheid: </label>';
                        if(!empty($bijlageVeiligheid)){// wanneer er een bestand is geupload
                            echo'<a class="downloadLink" target="_blank" href="'.$bijlageVeiligheid.'">'.$bijlageVeiligheid.'</a><br>';//print de downloadlink uit. Hier kunnen geen afbeeldingen geupload worden dus check is niet nodig.
                            $extension = explode(".", $bijlageVeiligheid);
                                if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){ // wanneer het bestand een afbeelding is
                                    echo '<img class="imageBekijken" src="'.$bijlageVeiligheid.'">'; // print de afbeelding
                                }
                        } else {// wanneer er geen bestand is geupload
                            echo'Geen bestand geupload.';
                        }
                echo'</p>
                    <p>
                        <label>Voorbereidende vragen: </label>
                        <textarea class="autoresizingBekijken" readonly>';
                            echo $voorbereidendevragen.'
                        </textarea>
                    </p>
                    <p>
                        <label>Download Voorbereidendevragen: </label>';
                        if(!empty($bijlageVoorbereidendevragen)){// wanneer er een bestand is geupload
                            echo'<a class="downloadLink" target="_blank" href="'.$bijlageVoorbereidendevragen.'">'.$bijlageVoorbereidendevragen.'</a><br>';//print de downloadlink uit.
                            $extension = explode(".", $bijlageVoorbereidendevragen);
                            if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){// wanneer het bestand een afbeelding is
                                echo '<img class="imageBekijken" src="'.$bijlageVoorbereidendevragen.'">';// print de afbeelding
                            }
                        } else {// wanneer er geen bestand is geupload
                            echo'Geen bestand geupload.';
                        }
              echo '</p>
                    
                        <br>
                        <div ID="Vakken">
                            Vak: '.$vak.'
                        </div>                                            
                        <br>
                        <div id="Jaren">
                        Jaar:  '.$jaar.'    
                        </div>
                        <br>
                    ';   
                    if($_SESSION['SorD'] == "Docent") 
                    {
                        echo '
                        <form class="" action="../Include/toevoegenBeoordelingvoorbereiding.inc.php?ID='.$ID.'" method="post">
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
