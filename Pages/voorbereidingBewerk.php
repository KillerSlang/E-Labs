<!DOCTYPE html>
<html lang="en">

    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/cda83c7af3.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="stylesheet" href="../Css/Responsive.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Voorbereiding bewerken</title>
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
                    if(!empty($_GET['addVoorbereiding']))// wanneer er een addvoorbereiding in de get staat.
                    {
                        echo'<div class="bericht">';
                            $addvoorbereiding = $_GET["addVoorbereiding"];
                            if($addvoorbereiding != "failed") // wanneer niet failed is.
                            {
                                echo'<b>De voorbereiding is opgeslagen.</b><hr>';
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
                    

                    $sql = 'SELECT voorbereidingTitel,uitvoerders,voorbereidingdatum,
                    uitvoeringDatum,theorie,benodigdeFormules,InstellingenApparaten,doel
                    hypothese,materialen,methode,veiligheid,voorbereidendeVragen,
                    ,vak,l.jaar
                    FROM voorbereiding as l '; //maak query aan
                    if($_SESSION['SorD'] == "Student")//wanneer de gebruiker student is.
                    {
                        $sql .= 'JOIN student AS s ON l.studentID = s.studentID
                        WHERE voorbereidingID = ? AND s.studentID = ?';
                        queryAanmaken(
                            $sql,
                            "ii",
                            $ID,$_SESSION["StudentID"]
                        );//student kan alleen voorbereiding bewerken waar hij auteur van is.
                    } 
                    else // docent komt niet op deze pagina. Dus deze else bestaat eigenlijk niet.
                    {
                        echo 'Session is niet ingevuld met student'; exit;
                    }                
                    mysqli_stmt_bind_result($stmt, $voorbereidingTitel, $uitvoerders, $voorbereidingdatum, $uitvoeringDatum, $benodigdeFormules, 
                                            $InstellingenApparaten, $doel, $hypothese, $materialen, $methode, $veiligheid, $voorbereidendeVragen,
                                            $vak, $jaar); // bind de resultaten
                    
                    mysqli_stmt_store_result($stmt);  //sla de resultaten op.                                                          
                    while (mysqli_stmt_fetch($stmt)) {  } 
                        /* maak de while statement aan en sluit deze.
                        omdat er altijd maar 1 resultaat is wordt deze meteen gesloten zodat de database connectie
                        weer kan worden gebruikt. */
                    querysluiten(); // sluit de connectie met de database.
          - - -  - - echo '<form class="Lform" action="../Include/editVoorbereiding.inc.php?ID='.$ID.'" method="post" enctype="multipart/form-data">            
                        <label for="titelvoorbereiding">Titel Voorbereiding: * </label>
                        <input type="text" id="titelvoorbereiding" name="titelvoorbereiding" value="'.$voorbereidingTitel.'" size="40">
                        
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
                        <label for="voorbereidingsdatum">Voorbereidings datum: * </label>
                        <input type="date" id="voorbereidingsdatum" name="voorbereidingsdatum" value="'.$voorbereidingsdatum.'">
            
                        </br>

                        <label for="uitvoeringsdatum">Uitvoerings datum: *</label>
                        <input type="date" id="experimentstartdatum" name="uitvoeringsdatum" value="'.$uitvoeringsdatum.'">
                 
                        </br>
            
                        <label for="uploadtheorie">Upload theorie: </label><p>Alleen afbeeldingen en word</p>
                        <input type="file" id="uploadveiligheid" name="uploadtheorie" accept=".image/*,.docx,.doc">

                        <br>
                        <br>

                        <label for="benodigdeFormules">Benodigde formules: </label>
                        <textarea id="weeggegevens" name="benodigdeFormules" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$benodigdeFormules.'"></textarea>

                        <br>
                        <br>

                        <label for="InstellingenApparaten">Instellingen apparaten: </label>
                        <textarea id="methode" name="instellingenapparaten" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$InstellingenApparaten.'"></textarea>
                                  

                        <label for="hypothese">Hypothese: </label>
                        <tex
                        
                        <label for="Hypothese">Hypothese: </label>
                        <textarea id="materialen" name="hypothese" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$hypothese.'"></textarea>

                        <br>
                        <br>

                        <label for="materialen">Materialen: </label>
                        <textarea id="materialen" name="materialen" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$materialen.'"></textarea>

                        <br>
                        <br>

                        <label>Upload Materialen bestand: </label><p>Alleen excel</p>
                        <input type="file" id="uploadwaarnemingen" name="uploadmaterialen" accept=".xls,.xlsx">

                        <br>
                        <br>

                        <label for="Methode">Methode: </label>
                        <textarea id="hypothese" name="methode" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$methode.'"></textarea>

                        <br>
                        <br>

                        <label>Upload methode bestand: </label><p>Alleen excel</p>
                        <input type="file" id="uploadmeetresultaten" name="uploadmethode" accept=".xls,.xlsx">

                        <br>
                        <br>

                        <label for="Veiligheid">Veiligheid: </label>
                        <textarea id="observaties" name="veiligheid" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$veiligheid.'"></textarea>
                        
                        <br>
                        <br>
                        
                        <label>Upload veiligheid bestand: </label><p>Alleen afbeeldingen en excel</p>
                        <input type="file" id="uploadlogboek" name="uploadveiligheid" accept="image/*,.xls,.xlsx">

                        <br>
                        <br>
                        

                        <label for="Voorbereidendevragen">Voorbereidende vragen: </label>
                        <textarea id="logboek" name="voorbereidendevragen" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$voorbereidendevragen.'"></textarea>

                        <br>
                        <br>
                        

                        <label>Upload voorbereidende vragen bestand: </label><p>Alleen afbeeldingen, excel, en word</p>
                        <input type="file" id="uploadlogboek" name="uploadvoorbereidendevragen" accept=".xls,.xlsx,.doc,.docx,image/*">

                        <br>
                        <br>
        }
                        <label for="Jaren">Jaar: *</label>
                                <div id="Jaren">';
                                if ($jaar == "1") 
                                {
                                    echo '<input type="radio" id="Jaar1" name="PJaar" value="1" checked>
                                    <label for="BML">Jaar 1</label><br>
                                    <input type="radio" id="Jaar2" name="PJaar" value="2">
                                    <label for="Chemie">Jaar 2</label><br>
                                    <input type="radio" id="Jaar3" name="PJaar" value="3">
                                    <label for="Chemie">Jaar 3</label>';
                                } elseif ($jaar == "2")
                                {
                                    echo '<input type="radio" id="Jaar1" name="PJaar" value="1">
                                    <label for="BML">Jaar 1</label><br>
                                    <input type="radio" id="Jaar2" name="PJaar" value="2" checked>
                                    <label for="Chemie">Jaar 2</label><br>
                                    <input type="radio" id="Jaar3" name="PJaar" value="3">
                                    <label for="Chemie">Jaar 3</label>';
                                } elseif ($jaar == "3") 
                                {
                                    echo '<input type="radio" id="Jaar1" name="PJaar" value="1" >
                                    <label for="BML">Jaar 1</label><br>
                                    <input type="radio" id="Jaar2" name="PJaar" value="2">
                                    <label for="Chemie">Jaar 2</label><br>
                                    <input type="radio" id="Jaar3" name="PJaar" value="3" checked>
                                    <label for="Chemie">Jaar 3</label>';
                                } else {
                                    echo '<input type="radio" id="Jaar1" name="PJaar" value="1" checked>
                                    <label for="BML">Jaar 1</label><br>
                                    <input type="radio" id="Jaar2" name="PJaar" value="2">
                                    <label for="Chemie">Jaar 2</label><br>
                                    <input type="radio" id="Jaar3" name="PJaar" value="3">
                                    <label for="Chemie">Jaar 3</label>';
                                }
                                echo '      
                                </div>        
                    <input class="bluebtn" type="Submit" id="LSubmit" name="LSubmit" value="Opslaan">
                </form> ';        
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
</html>/