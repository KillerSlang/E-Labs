<!DOCTYPE html>
<html lang="en">

    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="shortcut icon" type="image/png" href="../Images/favicon.png"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php
        if($_COOKIE['taal'] == 'english') {
            echo "<title>Edit Labjournal</title>";
        }
        else{
            echo "<title>Bewerk Labjournaal</title>";
        }
        ?>
        
    </head>

    <body>
    <?PHP
        /* Header */
        include_once '../Include/Header.php';
        include_once '../Include/Dbh.inc.php';
    ?>

    <main id="Labjournaal">
        <div class="PageTitle">
            <h1><?=$Labjournaal?></h1>
            <hr>
        </div>
        <div class="whitebg">
            <div class="content">
                <?PHP
                    if(!empty($_GET['addLabjournaal']))// wanneer er een addlabjournaal in de get staat.
                    {
                        echo'<div class="bericht">';
                            $addlabjournaal = $_GET["addLabjournaal"];
                            if($addlabjournaal != "failed") // wanneer niet failed is.
                            {
                                echo'<b>Het labjournaal is opgeslagen.</b><hr>';
                            }
                            else // anders
                            {
                                echo'<b>Niet alle velden zijn ingevuld</b><hr>';
                            }
                        echo'</div>';
                    }
                    if(!empty($_GET['ID'])) // wanneer er een ID in de GET staat
                    {
                        $ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
                    }else{ $ID = 0; }// anders wordt ID 0 om geen error te veroorzaken. 
                    
                    function getName($bestandsLocatie)
                    {
                        $explode =  explode("/",$bestandsLocatie);
                        $bestandsNaam = end($explode);
                        return $bestandsNaam; 
                    }

                    $sql = 'SELECT labjournaalTitel,uitvoerders,experimentdatum,
                    experimentBeginDatum,experimentEindDatum,veiligheid,doel,bijlageWaarnemingen,
                    hypothese,materialen,methode,bijlageMeetresultaten,logboek,bijlageLogboek,
                    observaties,bijlageObservaties,weeggegevens,bijlageWeeggegevens,
                    bijlageAfbeelding,vak
                    FROM labjournaal as l '; //maak query aan
                    if($_SESSION['SorD'] == "Student")//wanneer de gebruiker student is.
                    {
                        $sql .= 'JOIN student AS s ON l.studentID = s.studentID
                        WHERE labjournaalID = ? AND s.studentID = ?';
                        queryAanmaken(
                            $sql,
                            "ii",
                            $ID,$_SESSION["StudentID"]
                        );//student kan alleen labjournalen bewerken waar hij auteur van is.
                    } 
                    else // docent komt niet op deze pagina. Dus deze else bestaat eigenlijk niet.
                    {
                        echo 'Session is niet ingevuld met student'; exit;
                    }                
                    mysqli_stmt_bind_result($stmt, $labjournaalTitel, $uitvoerders, $experimentDatum, $experimentBeginDatum, $experimentEindDatum, 
                                            $veiligheid, $doel, $bijlageWaarnemingen, $hypothese, $materialen, $methode, $bijlageMeetresultaten, $logboek,
                                            $bijlageLogboek, $observaties, $bijlageObservaties, $weeggegevens, $bijlageWeeggegevens, $bijlageAfbeelding,
                                            $vak); // bind de resultaten                    
                    mysqli_stmt_store_result($stmt);  //sla de resultaten op.
                    while (mysqli_stmt_fetch($stmt)) {  }
                        /* maak de while statement aan en sluit deze.
                        omdat er altijd maar 1 resultaat is wordt deze meteen gesloten zodat de database connectie
                        weer kan worden gebruikt. */
                    querysluiten(); // sluit de connectie met de database.
                echo '<form class="Lform" action="../Include/editlabjournaal.inc.php?ID='.$ID.'" method="post" enctype="multipart/form-data">            
                        <label for="titellabjournaal">'.$LabjournaalTitel.':  </label>
                        <input type="text" id="titellabjournaal" name="titelLabjournaal" value="'.$labjournaalTitel.'">
                        
                        <label for="uitvoerders">'.$LabjournaalUitvoerder.':  </label>
                        <input type="number" id="uitvoerders" name="uitvoerders" placeholder="'.$StudentNummer.'" >'; 
                        if(isset($_GET['NEW']))//alleen wanneer je van de overzichtpagina komt de uitvoerders uit de database halen
                        {
                            $uitvoerdersArray = unserialize(base64_decode($uitvoerders));// haal de uitvoerders array uit de database.
                            if(empty($_SESSION ['studentNaamArray']))
                            { 
                                foreach($uitvoerdersArray as $uitvoerder)
                                {
                                    queryAanmaken( //zoek de naam van de uitvoerders op in de database.
                                        'SELECT studentNaam
                                        FROM student
                                        WHERE studentNummer = ?',
                                        "i",$uitvoerder);
                                    mysqli_stmt_bind_result($stmt, $studentNaam); // bind het resultaat
                                    mysqli_stmt_store_result($stmt); // sla het resultaat op
                                    while (mysqli_stmt_fetch($stmt)) 
                                    {
                                        if (empty($_SESSION ['studentNummerArray'])) //wanneer er nog geen studentNummerArray bestaat.
                                        {
                                            $_SESSION ['studentNaamArray'] =  array(); // maak 2 nieuwe arrays aan voor de namen en nummers van de studenten.
                                            $_SESSION ['studentNummerArray'] =  array();
                                        }
                                        array_push($_SESSION ['studentNaamArray'],$studentNaam); //voeg de naam aan de array toe.  
                                        array_push($_SESSION ['studentNummerArray'],$uitvoerder); //voeg het studentnumemr aan de array toe.   
                                    }
                                    querySluiten();//sluit de connectie met de database.
                                }  

                            }
                        }
                        if (isset($_SESSION["studentNaamArray"])) //wanneer de session studentNaamArray bestaat.
                        {
                            foreach($_SESSION["studentNaamArray"] as $naam) // voor elke naam die in de array staat.
                            {
                                echo '<input type="text" class="studentInput" value=" '.$naam.'" readonly/>' ; //print de naam uit
                            }
                        } 
                        if(isset($_GET["adduser"]))//wanneer er een adduser in de GET staat.
                        {
                            if($_GET["adduser"] == "failed") //Wanneer de get failed is.
                            {
                                echo  'Het studentnummer is niet gevonden in de database.' ;
                            }
                        }
                        echo'
                        <div id="buttonArea">
                            <button class="userToevoegen" type="Submit" id="userSubmit" name="userSubmit">
                                <i class="fa fa-user-plus"> </i>
                            </button>
                            <button class="userVerwijderen" type="Submit" id="userVerwijderen" name="userVerwijderen">
                                <i class="fa fa-user-times"> </i>
                            </button>
                        </div>
                        <br>        
                        <label for="experimentdatum">'.$LabjournaalDatum.': </label>
                        <input type="date" id="experimentdatum" name="experimentdatum" value="'.$experimentDatum.'">
            
                        <label for="experimentstartdatum">'.$LabjournaalDatumS.':</label>
                        <input type="date" id="experimentstartdatum" name="experimentstartdatum" value="'.$experimentBeginDatum.'">
            
                        <label for="experimenteinddatum">'.$LabjournaalDatumE.':</label>
                        <input type="date" id="experimenteinddatum" name="experimenteinddatum" value="'.$experimentEindDatum.'">        
                        <br>
            
                        <label for="uploadveiligheid">'.$LabjournaalVeiligheid.':</label>
                        <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept=".xls,.xlsx,image/*">';
                        if(!empty($veiligheid)){
                            echo'<a class="downloadLink"  target="_blank" href="'.$veiligheid.'">'; getName($veiligheid); echo'</a>';
                        }
                        echo'                    
                        <br>
                        <br>
                        <label>'.$LabjournaalDoel.': </label>
                        <textarea name="doel" class="autoresizingBewerken" placeholder="'.$LabGegevens.'">'.$doel.'</textarea>        
                        <br>
                        <br>        
                        <label>'.$LabjournaalWaarneming.': </label><p>'.$AlleenAfbeeldingen.'</p>
                        <input type="file" id="uploadwaarnemingen" name="uploadwaarnemingen" accept="image/*">';
                        if(!empty($bijlageWaarnemingen)){
                            echo'<a class="downloadLink"  target="_blank" href="'.$bijlageWaarnemingen.'">'; getName($bijlageWaarnemingen); echo'</a>';
                        } 
                        echo'                
                        <label>'.$LabjournaalHypothese.': </label>
                        <textarea name="hypothese" class="autoresizingBewerken" placeholder="'.$LabGegevens.'">'.$hypothese.' </textarea>        
                        <br>
                        <br>        
                        <label for="materialen">'.$LabjournaalMateriaal.':</label>
                        <textarea id="materialen" name="materialen" class="autoresizingBewerken" placeholder="'.$LabGegevens.'">'.$materialen.'</textarea>        
                        <br>
                        <br>        
                        <label for="methode">'.$LabjournaalMethode.':</label>
                        <textarea id="methode" name="methode" class="autoresizingBewerken" placeholder="'.$LabGegevens.'">'.$methode.'</textarea>        
                        <br>
                        <br>        
                        <label for="uploadmeetresultaten">'.$LabjournaalMeetR.':</label>
                        <input type="file" id="uploadmeetresultaten" name="uploadmeetresultaten" accept=".xls,.xlsx,image/*">';
                        if(!empty($bijlageMeetresultaten)){
                            echo'<a class="downloadLink"  target="_blank" href="'.$bijlageMeetresultaten.'">'; getName($bijlageMeetresultaten); echo'</a>';
                        }
                        echo'               
                        <br>
                        <br>                    
                        <label for="logboek">'.$LabjournaalLogboek.':</label>
                        <textarea id="logboek" name="logboek" class="autoresizingBewerken" placeholder="'.$LabGegevens.'">'.$logboek.'</textarea>        
                        <br>
                        <br>                    
                        <label for="uploadlogboek">'.$LabjournaalLogboekU.': </label>
                        <input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx">';
                        if(!empty($bijlageLogboek)){
                            echo'<a class="downloadLink"  target="_blank" href="'.$bijlageLogboek.'">'; getName($bijlageLogboek); echo'</a>';
                        }
                        echo'
                        <br>
                        <br>        
                        <label for="observaties">'.$LabjournaalObservatie.': </label>
                        <textarea id="observaties" name="observaties" class="autoresizingBewerken" placeholder="'.$LabGegevens.'">'.$observaties.'</textarea>        
                        <br>
                        <br>                  
                        <label for="uploadobservaties">'.$LabjournaalObservatieU.': </label>
                        <input type="file" id="uploadobservaties" name="uploadobservaties" accept="image/*,.doc,.docx">';
                        if(!empty($bijlageObservaties)){
                            echo'<a class="downloadLink"  target="_blank" href="'.$bijlageObservaties.'">'; getName($bijlageObservaties); echo'</a>';
                        }
                        echo'       
                        <br>
                        <br>        
                        <label for="weeggegevens">'.$LabjournaalWeeg.': </label>
                        <textarea id="weeggegevens" name="weeggegevens" class="autoresizingBewerken" placeholder="'.$LabGegevens.'">'.$weeggegevens.'</textarea>                    
                        <br>
                        <br>                    
                        <label >'.$LabjournaalWeegU.': </label>
                        <input type="file" id="uploadweeggegevens" name="uploadweeggegevens" accept=".xls,.xlsx">';
                        if(!empty($bijlageWeeggegevens)){
                            echo'<a class="downloadLink"  target="_blank" href="'.$bijlageWeeggegevens.'">'; getName($bijlageWeeggegevens); echo'</a>';
                        }
                        echo'
                        <br>
                        <br>        
                        <label for="uploadafbeelding">'.$LabjournaalImg.': </label>
                        <input type="file" id="uploadafbeelding" name="uploadafbeelding" accept="image/*" multiple>';
                        if(!empty($bijlageAfbeelding)){
                            echo'<a class="downloadLink"  target="_blank" href="'.$bijlageAfbeelding.'">'; getName($bijlageAfbeelding); echo'</a>';
                        }
                        echo'        
                        <br>
                        <br>
                        <label>'.$Vak.': </label>
                                <div id="Vakken">';
                                    if ($vak == "BML")
                                    {
                                        echo'
                                        <input type="radio" id="BML" name="LVak" value="BML" checked>
                                        <label for="BML">'.$BML.'</label><br>
                                        <input type="radio" id="Chemie" name="LVak" value="Chemie">
                                        <label for="Chemie">'.$Chemie.'</label>';
                                    }
                                    else
                                    {
                                        echo'
                                        <input type="radio" id="BML" name="LVak" value="BML">
                                        <label for="BML">'.$BML.'</label><br>
                                        <input type="radio" id="Chemie" name="LVak" value="Chemie" checked>
                                        <label for="Chemie">'.$Chemie.'</label>';
                                    }
                    echo'
                    </div><br><br>
                    <input class="bluebtn" type="Submit" id="LSubmit" name="LSubmit" value="'.$Opslaan.'">
                </form>';        
                ?>
    </div>
    </div>            
    </main>
    <script type="text/javascript">//functie voor het automatisch instellen van de hoogte voor de tekstvakken.
        textarea = document.querySelectorAll(".autoresizingBewerken");
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