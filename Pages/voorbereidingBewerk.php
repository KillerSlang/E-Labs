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
                    

                    $sql = 'SELECT voorbereidingTitel, voorbereidingDatum, materialen, methode, hypothese, instellingenApparaten,
                             voorbereidendeVragen, veiligheid, vak, uitvoerders, uitvoeringsDatum, benodigdeFormules, bijlageTheorie,
                             bijlageMaterialen, bijlageMethode, bijlageVeiligheid, bijlageVoorbereidendevragen, doel
                    FROM voorbereiding as l '; //maak query aan
                    if($_SESSION['SorD'] == "Student")//wanneer de gebruiker student is.
                    {
                        $sql .= 'JOIN student AS s ON l.studentID = s.studentID
                        WHERE voorbereidingID = ? AND s.studentID = ?';
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
                    mysqli_stmt_bind_result($stmt, $voorbereidingTitel, $voorbereidingDatum, $materialen, $methode, $hypothese, $instellingenApparaten,
                                            $voorbereidendeVragen, $veiligheid, $vak, $uitvoerders, $uitvoeringsDatum, $benodigdeFormules, $bijlageTheorie,
                                            $bijlageMaterialen, $bijlageMethode, $bijlageVeiligheid, $bijlageVoorbereidendevragen, $doel); // bind de resultaten                    
                    mysqli_stmt_store_result($stmt);  //sla de resultaten op.
                    while (mysqli_stmt_fetch($stmt)) {  }
                        /* maak de while statement aan en sluit deze.
                        omdat er altijd maar 1 resultaat is wordt deze meteen gesloten zodat de database connectie
                        weer kan worden gebruikt. */
                    querysluiten(); // sluit de connectie met de database.
                echo '<form class="Lform" action="../Include/editlabjournaal.inc.php?ID='.$ID.'" method="post" enctype="multipart/form-data">            
                        <label for="titelvoorbereiding">Titel voorbereiding: * </label>
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
                        <label for="voorbereidingsDatum">voorbereidings datum: * </label>
                        <input type="date" id="voorbereidingsDatum" name="voorbereidingsDatum" placeholder="dd/mm/yyyy" value="'.$voorbereidingDatum.'">
            
                        <label for="uitvoeringsDatum">uitvoerings datum: </label>
                        <input type="date" id="uitvoeringsDatum" name="uitvoeringsDatum" placeholder="dd/mm/yyyy" value="'.$uitvoeringsDatum.'">
                    
                        <br>
            
                        <label for="uploadtheorie">Upload theorie: </label>
                        <input type="file" id="uploadtheorie" name="uploadtheorie" accept=".xls,.xlsx,image/*" value="'.$bijlageTheorie.'">';
                        if(!empty($bijlageTheorie)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$bijlageTheorie.'">'.$bijlageTheorie.'</a>';
                        }
                        echo'                    
                        <br>
                        <br>
                        <label for="benodigdeFormules">benodigdeFormules: </label>
                        <textarea name="benodigdeFormules" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$benodigdeFormules.'</textarea>        
                        <br>
                        <br>  
                        <label for="InstellingenApparaten">InstellingenApparaten: </label>
                        <textarea name="InstellingenApparaten" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$instellingenApparaten.' </textarea>        
                        <br>
                        <br> 
                        <label for="doel">doel: </label>
                        <textarea name="doel" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$doel.'</textarea>        
                        <br>
                        <br>        
                        <label for="Hypothese">Hypothese: </label>
                        <textarea name="Hypothese" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$hypothese.'</textarea>        
                        <br>
                        <br>
                        <label for="materialen">Materialen: </label>
                        <textarea id="materialen" name="materialen" rows="4" cols="50" placeholder="Voer gegevens in...">'.$materialen.'</textarea>

                        <br>
                        <br>         
                        <label for="uploadmaterialen">Upload Materialen bestand: </label>
                        <input type="file" id="uploadmaterialen" name="uploadmaterialen" accept="image/*value="'.$bijlageMaterialen.'">
                        <br>
                        <br>';
                        if(!empty($bijlageMaterialen)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$bijlageMaterialen.'">'.$bijlageMaterialen.'</a>';
                        } 
                        echo'                
                        <label for="Methode">Methode: </label>
                        <textarea id="methode" name="methode" rows="4" cols="50" placeholder="Voer gegevens in...">'.$methode.'</textarea>
            
                        <br>
                        <br>   
                        <label for="uploadmethode">Upload methode bestand: </label>
                        <input type="file" id="uploadmethode" name="uploadmethode" accept=".xls,.xlsx,image/* value='.$bijlageMethode.'>';
                        if(!empty($bijlageMethode)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$bijlageMethode.'">'.$bijlageMethode.'</a>';
                        }
                        echo'               
                        <label for="Veiligheid">Veiligheid: </label>
                        <textarea id="veiligheid" name="veiligheid" rows="4" cols="50" placeholder="Voer gegevens in...">'.$veiligheid.'</textarea>
                        
                        <br>
                        <br>                    
                                     
                        <label for="uploadveiligheid">Upload veiligheid bestand: </label>
                        <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept=".xls,.xlsx,.doc,.docx" value='.$bijlageVeiligheid.'>';
                        if(!empty($bijlageVeiligheid)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$bijlageVeiligheid.'">'.$bijlageVeiligheid.'</a>';
                        }
                        echo'
                        <br>
                        <br>        
                        <label for="Voorbereidendevragen">Voorbereidende Vragen: </label>
                        <textarea name="Voorbereidendevragen" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$voorbereidendeVragen.'</textarea>        
                        <br>
                        <br>                  
                        <label for="uploadvoorbereidendevragen">Upload voorbereidendevragen bestand: </label>
                        <input type="file" id="uploadvoorbereidendevragen" name="uploadvoorbereidendevragen" accept="image/*,.doc,.docx" value='.$bijlageVoorbereidendevragen.'>';
                        if(!empty($bijlageVoorbereidendevragen)){
                            echo'<a class="downloadLink" " target="_blank" href="'.$bijlageVoorbereidendevragen.'">'.$bijlageVoorbereidendevragen.'</a>';
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