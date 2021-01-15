<!DOCTYPE html>
<html lang="en">

    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="stylesheet" href="../Css/Responsive.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php
        if($_COOKIE['taal'] == 'english') {
            echo "<title>Edit Lab journal</title>";
        }
        if($_COOKIE['taal'] == 'nederlands') {
            echo "<title>Labjournaal Bewerken</title>";
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
            <h1>Labjournaal</h1>
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
                        <label for="titellabjournaal">Titel experiment: * </label>
                        <input type="text" id="titellabjournaal" name="titelLabjournaal" value="'.$labjournaalTitel.'" size="40">
                        
                        <label for="uitvoerders">Uitvoerders: * </label>
                        <input type="number" id="uitvoerders" name="uitvoerders" placeholder="studentnummer"  size="40">'; 
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
                                <i class="fas fa-user-plus"> </i>
                            </button>
                            <button class="userVerwijderen" type="Submit" id="userVerwijderen" name="userVerwijderen">
                                <i class="fas fa-user-minus"> </i>
                            </button>
                        </div>
                        <br>        
                        <label for="experimentdatum">Experiment datum: * </label>
                        <input type="date" id="experimentdatum" name="experimentdatum" value="'.$experimentDatum.'">
            
                        <label for="experimentstartdatum">Start datum experiment: </label>
                        <input type="date" id="experimentstartdatum" name="experimentstartdatum" value="'.$experimentBeginDatum.'">
            
                        <label for="experimenteinddatum">Eind datum experiment: </label>
                        <input type="date" id="experimenteinddatum" name="experimenteinddatum" value="'.$experimentEindDatum.'">        
                        <br>
            
                        <label for="uploadveiligheid">Upload veiligheid: </label>
                        <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept=".xls,.xlsx,image/*" value="'.$veiligheid.'">';
                        if(!empty($veiligheid)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$veiligheid.'">'.$veiligheid.'</a>';
                        }
                        echo'                    
                        <br>
                        <br>
                        <label for="doel">Doel: </label>
                        <textarea name="doel" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$doel.'</textarea>        
                        <br>
                        <br>        
                        <label for="uploadwaarnemingen">Upload waarnemingen bestand: </label>
                        <input type="file" id="uploadwaarnemingen" name="uploadwaarnemingen" accept="image/*">
                        <br>
                        <br>';
                        if(!empty($bijlageWaarnemingen)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$bijlageWaarnemingen.'">'.$bijlageWaarnemingen.'</a>';
                        } 
                        echo'                
                        <label for="hypothese">Hypothese: </label>
                        <textarea name="hypothese" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$hypothese.' </textarea>        
                        <br>
                        <br>        
                        <label for="materialen">Materialen: </label>
                        <textarea name="materialen" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$materialen.'</textarea>        
                        <br>
                        <br>        
                        <label for="methode">Methode: </label>
                        <textarea name="methode" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$methode.'</textarea>        
                        <br>
                        <br>        
                        <label for="uploadmeetresultaten">Upload meetresultaten bestand: </label>
                        <input type="file" id="uploadmeetresultaten" name="uploadmeetresultaten" accept=".xls,.xlsx,image/*">';
                        if(!empty($bijlageMeetresultaten)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$bijlageMeetresultaten.'">'.$bijlageMeetresultaten.'</a>';
                        }
                        echo'               
                        <br>
                        <br>                    
                        <label for="logboek">Logboek: </label>
                        <textarea name="logboek" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$logboek.'</textarea>        
                        <br>
                        <br>                    
                        <label for="uploadlogboek">Upload logboek bestand: </label>
                        <input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx">';
                        if(!empty($bijlageLogboek)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$bijlageLogboek.'">'.$bijlageLogboek.'</a>';
                        }
                        echo'
                        <br>
                        <br>        
                        <label for="observaties">Observaties: </label>
                        <textarea name="observaties" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$observaties.'</textarea>        
                        <br>
                        <br>                  
                        <label for="uploadobservaties">Upload observatie bestand: </label>
                        <input type="file" id="uploadobservaties" name="uploadobservaties" accept="image/*,.doc,.docx">';
                        if(!empty($bijlageObservaties)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$bijlageObservaties.'">'.$bijlageObservaties.'</a>';
                        }
                        echo'       
                        <br>
                        <br>        
                        <label for="weeggegevens">Weeggegevens: </label>
                        <textarea name="weeggegevens" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$weeggegevens.'</textarea>                    
                        <br>
                        <br>                    
                        <label for="uploadweegegevens">Upload weeggegevens bestand: </label>
                        <input type="file" id="uploadweeggegevens" name="uploadweeggegevens" accept=".xls,.xlsx">';
                        if(!empty($bijlageWeeggegevens)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$bijlageWeeggegevens.'">'.$bijlageWeeggegevens.'</a>';
                        }
                        echo'
                        <br>
                        <br>        
                        <label for="uploadafbeelding">Upload afbeeldingen: </label>
                        <input type="file" id="uploadafbeelding" name="uploadafbeelding" accept="image/*" multiple>';
                        if(!empty($bijlageAfbeelding)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$bijlageAfbeelding.'">'.$bijlageAfbeelding.'</a>';
                        }
                        echo'        
                        <br>
                        <br>
                        <label for="Vakken">Vak: *</label>
                                <div id="Vakken">';
                                    if ($vak == "BML")
                                    {
                                        echo'
                                        <input type="radio" id="BML" name="LVak" value="BML" checked>
                                        <label for="BML">BML</label><br>
                                        <input type="radio" id="Chemie" name="LVak" value="Chemie">
                                        <label for="Chemie">Chemie</label>';
                                    }
                                    else
                                    {
                                        echo'
                                        <input type="radio" id="BML" name="LVak" value="BML">
                                        <label for="BML">BML</label><br>
                                        <input type="radio" id="Chemie" name="LVak" value="Chemie" checked>
                                        <label for="Chemie">Chemie</label>';
                                    }
                    echo'
                    <br><br>
                    <input class="bluebtn" type="Submit" id="LSubmit" name="LSubmit" value="Opslaan">
                </form>';        
                ?>
                
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