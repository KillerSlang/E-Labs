<!DOCTYPE html>
<html>

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
                if(!empty($_GET['addLabjournaal']))
                {
                    echo'<div class="bericht">';
                        $addlabjournaal = $_GET["addLabjournaal"];
                        if($addlabjournaal != "failed")
                        {
                            echo'<b>Het labjournaal is opgeslagen.</b><hr>';
                        }
                        else
                        {
                            echo'<b>Niet alle velden zijn ingevuld</b><hr>';
                        }
                    echo'</div>';
                }
				if(!empty($_GET['ID']))
				{
					$ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
                }else{ $ID = 0; }
                

                $sql = 'SELECT labjournaalTitel,uitvoerders,experimentdatum,
				experimentBeginDatum,experimentEindDatum,veiligheid,doel,bijlageWaarnemingen,
				hypothese,materialen,methode,bijlageMeetresultaten,logboek,bijlageLogboek,
				observaties,bijlageObservaties,weeggegevens,bijlageWeeggegevens,
				bijlageAfbeelding,vak,l.jaar
                FROM labjournaal as l ';
                if($_SESSION['SorD'] == "Student")
                {
                    $sql .= 'JOIN student AS s ON l.studentID = s.studentID
                    WHERE labjournaalID ='.$ID.' AND s.studentID = '.$_SESSION["StudentID"];      // student of docent
                } 
                else
                {
                    $sql .= 'WHERE labjournaalID ='.$ID;
                }
                queryAanmaken($sql);
                
                mysqli_stmt_bind_result($stmt, $labjournaalTitel, $uitvoerders, $experimentDatum, $experimentBeginDatum, $experimentEindDatum, 
                                        $veiligheid, $doel, $bijlageWaarnemingen, $hypothese, $materialen, $methode, $bijlageMeetresultaten, $logboek,
                                        $bijlageLogboek, $observaties, $bijlageObservaties, $weeggegevens, $bijlageWeeggegevens, $bijlageAfbeelding,
                                        $vak, $jaar);
                
                mysqli_stmt_store_result($stmt);  
                 
                                              
                while (mysqli_stmt_fetch($stmt)) {  } 
                querysluiten();
                    echo '<form class="Lform" action="../Include/editlabjournaal.inc.php" method="post" enctype="multipart/form-data">
            
                    <label for="titellabjournaal">Titel experiment: * </label>
                    <input type="text" id="titellabjournaal" name="titelLabjournaal" value="'.$labjournaalTitel.'" size="40">
                    
                    <label for="uitvoerders">Uitvoerders: * </label>
                    <input type="number" id="uitvoerders" name="uitvoerders" placeholder="studentnummer"  size="40">
                    '; 
                   /* $uitvoerdersArray = unserialize(base64_decode($uitvoerders));
                    if(empty($_SESSION ['studentNaamArray']))
                    { 
                        foreach($uitvoerdersArray as $uitvoerder)
                        {
                            queryAanmaken(
                                'SELECT studentNaam
                                FROM student
                                WHERE studentNummer = '.$uitvoerder);
                            mysqli_stmt_bind_result($stmt, $studentNaam);
                            mysqli_stmt_store_result($stmt);
                            while (mysqli_stmt_fetch($stmt)) 
                            {
                                if (empty($_SESSION ['studentNummerArray']))
                                {
                                    $_SESSION ['studentNaamArray'] =  array();
                                    $_SESSION ['studentNummerArray'] =  array();
                                }
                                array_push($_SESSION ['studentNaamArray'],$studentNaam);  
                                array_push($_SESSION ['studentNummerArray'],$uitvoerder);   
                            }echo '<input type="text" class="studentInput" value=" '.$studentNaam.'" size="40" readonly/>' ;
                            querySluiten();
                        }  

                    }
                    if (isset($_SESSION["studentNaamArray"]))
                    {
                        foreach($_SESSION["studentNaamArray"] as $naam)
                        {
                            echo '<input type="text" class="studentInput" value=" '.$naam.'" size="40" readonly/>' ;
                        }
                    } 
                    if(isset($_GET["adduser"]))
                    {
                        if($_GET["adduser"] == "failed")
                        {
                            echo  'Het studentnummer is niet gevonden in de database.' ;
                        }
                    }*/
                    echo'
                    <br>
        
                    <label for="experimentdatum">Experiment datum: * </label>
                    <input type="date" id="experimentdatum" name="experimentdatum" value="'.$experimentDatum.'">
        
                    <label for="experimentstartdatum">Start datum experiment: </label>
                    <input type="date" id="experimentstartdatum" name="experimentstartdatum" value="'.$experimentBeginDatum.'">
        
                    <label for="experimenteinddatum">Eind datum experiment: </label>
                    <input type="date" id="experimenteinddatum" name="experimenteinddatum" value="'.$experimentEindDatum.'">
        
                    <br>
        
                    <label for="uploadveiligheid">Upload veiligheid: </label>
                    <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept=".xls,.xlsx,image/*">
        
                    <br>
                    <br>
        
                    <label for="doel">Doel: </label>
                    <textarea name="doel" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$doel.'</textarea>
        
                    <br>
                    <br>
        
                    <label for="uploadwaarnemingen">Upload waarnemingen bestand: </label>
                    <input type="file" id="uploadwaarnemingen" name="uploadwaarnemingen" accept="image/*">
        
                    <br>
                    <br>
                
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
                    <input type="file" id="uploadmeetresultaten" name="uploadmeetresultaten" accept=".xls,.xlsx,image/*">
        
                    <br>
                    <br>
                    
                    <label for="logboek">Logboek: </label>
                    <textarea name="logboek" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$logboek.'</textarea>
        
                    <br>
                    <br>
                    
                    <label for="uploadlogboek">Upload logboek bestand: </label>
                    <input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx">
        
                    <br>
                    <br>
        
                    <label for="observaties">Observaties: </label>
                    <textarea name="observaties" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$observaties.'</textarea>
        
                    <br>
                    <br>
                    
                    <label for="uploadobservaties">Upload observatie bestand: </label>
                    <input type="file" id="uploadobservaties" name="uploadobservaties" accept="image/*,.doc,.docx">
        
                    <br>
                    <br>
        
                    <label for="weeggegevens">Weeggegevens: </label>
                    <textarea name="weeggegevens" class="autoresizingBewerken" placeholder="Voer gegevens in...">'.$weeggegevens.'</textarea>
        
                    <br>
                    <br>
                    
                    <label for="uploadweegegevens">Upload weeggegevens bestand: </label>
                    <input type="file" id="uploadweeggegevens" name="uploadweeggegevens" accept=".xls,.xlsx">
        
                    <br>
                    <br>
        
                    <label for="uploadafbeelding">Upload afbeeldingen: </label>
                    <input type="file" id="uploadafbeelding" name="uploadafbeelding" accept="image/*" multiple>
        
                    <br>
                    <br>
                    <label for="Vakken">Vak: *</label>
                            <div name="Vakken">';
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
                    echo ' 
                            </div>    
        
                        
                            <br>
                               
        
                    <label for="Jaren">Jaar: *</label>
                            <div name="Jaren">';
                            if ($jaar == "1") 
                            {
                                echo '<input type="radio" id="Jaar 1" name="PJaar" value="1" checked>
                                <label for="BML">Jaar 1</label><br>
                                <input type="radio" id="Jaar 2" name="PJaar" value="2">
                                <label for="Chemie">Jaar 2</label><br>
                                <input type="radio" id="Jaar 3" name="PJaar" value="3">
                                <label for="Chemie">Jaar 3</label>';
                            } elseif ($jaar == "2")
                            {
                                echo '<input type="radio" id="Jaar 1" name="PJaar" value="1">
                                <label for="BML">Jaar 1</label><br>
                                <input type="radio" id="Jaar 2" name="PJaar" value="2" checked>
                                <label for="Chemie">Jaar 2</label><br>
                                <input type="radio" id="Jaar 3" name="PJaar" value="3">
                                <label for="Chemie">Jaar 3</label>';
                            } elseif ($jaar == "3") 
                            {
                                echo '<input type="radio" id="Jaar 1" name="PJaar" value="1" >
                                <label for="BML">Jaar 1</label><br>
                                <input type="radio" id="Jaar 2" name="PJaar" value="2">
                                <label for="Chemie">Jaar 2</label><br>
                                <input type="radio" id="Jaar 3" name="PJaar" value="3" checked>
                                <label for="Chemie">Jaar 3</label>';
                            } else {
                                echo '<input type="radio" id="Jaar 1" name="PJaar" value="1" checked>
                                <label for="BML">Jaar 1</label><br>
                                <input type="radio" id="Jaar 2" name="PJaar" value="2">
                                <label for="Chemie">Jaar 2</label><br>
                                <input type="radio" id="Jaar 3" name="PJaar" value="3">
                                <label for="Chemie">Jaar 3</label>';
                            }
                            echo '
       
                            </div>
        
                            <br>
                            <br>
        
                    <input class="bluebtn" type="Submit" id="LSubmit" name="LSubmit" value="Opslaan">
            </form>';        
            ?>
            
</main>
<script type="text/javascript">
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